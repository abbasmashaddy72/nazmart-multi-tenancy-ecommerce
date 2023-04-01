<?php

namespace App\Http\Services;

use App\Models\OrderProducts;
use App\Models\ProductOrder;
use App\Models\User;
use App\Models\UserDeliveryAddress;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Attributes\Entities\Category;
use Modules\CountryManage\Entities\Country;
use Modules\CountryManage\Entities\State;
use Modules\CouponManage\Entities\ProductCoupon;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\ProductChildCategory;
use Modules\Product\Entities\ProductSubCategory;
use Modules\ShippingModule\Entities\ShippingMethod;
use Modules\ShippingModule\Entities\ZoneRegion;
use Modules\TaxModule\Entities\CountryTax;
use Modules\TaxModule\Entities\StateTax;
use Xgenious\Paymentgateway\Facades\XgPaymentGateway;

class ProductCheckoutService
{
    public function getOrCreateUser($validated_data): array
    {
        $user = Auth::guard('web')->user();
        if ($user == null || ($user != null && $user->delivery_address == null)) { // get non-logged in user or user with no billing address
            $name = $validated_data['name'];
            $email = trim(strtolower($validated_data['email']));
            $phone = $validated_data['phone'];

            $country_id = $validated_data['country'];
            $country_name = Country::find($country_id)->first()->name;

            $state_id = $validated_data['state'];
            $state_name = State::find($state_id)->first()->name;

            $city = $validated_data['city'];
            $address = $validated_data['address'];

            $user = [
                'id' => !empty($user) ? $user->id : null,
                'name' => $name,
                'email' => $email,
                'mobile' => $phone,
                'country_name' => $country_name,
                'country' => $country_id,
                'state_name' => $state_name,
                'state' => $state_id,
                'city' => $city,
                'address' => $address
            ];

            if (array_key_exists('create_accounts_input', $validated_data) && $validated_data['create_accounts_input'] != null) // create new user
            {
                $username = $validated_data['create_username'];
                $password = $validated_data['create_password'];
                $username = create_slug($username, 'User', false, '', 'username');

                $user = User::create([
                    'username' => $username,
                    'password' => \Hash::make($password),
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $phone,
                    'country' => $country_name,
                    'state' => $state_name,
                    'city' => $city,
                    'address' => $address
                ]);

                $user_delivery_address = UserDeliveryAddress::create([
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                    'email' => $email,
                    'phone' => $phone,
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'city' => $city,
                    'address' => $address,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $user = [
                    'id' => $user->id,
                    'name' => $user_delivery_address->full_name,
                    'email' => $user_delivery_address->email,
                    'mobile' => $user_delivery_address->phone,
                    'country' => $user_delivery_address->country_id,
                    'state' => $user_delivery_address->state_id,
                    'city' => $user_delivery_address->city,
                    'address' => $user_delivery_address->address
                ];
            }
        } else { // get logged in user address with billing info
            if ($validated_data['shift_another_address'] == 'on') {
                $user = [
                    'id' => $user->id,
                    'name' => $validated_data['shift_name'],
                    'email' => $validated_data['shift_email'],
                    'mobile' => $validated_data['shift_phone'],
                    'country' => $validated_data['shift_country'],
                    'state' => $validated_data['shift_state'],
                    'city' => $validated_data['shift_city'],
                    'address' => $validated_data['shift_address']
                ];
            } else {
                $user_address = $user->delivery_address;
                $user = [
                    'id' => $user->id,
                    'name' => $user_address->full_name,
                    'email' => $user_address->email,
                    'mobile' => $user_address->phone,
                    'country' => $user_address->country_id,
                    'state' => $user_address->state_id,
                    'city' => $user_address->city,
                    'address' => $user_address->address
                ];
            }
        }

        return $user;
    }

    public static function getCartProducts(): array
    {
        $cartArr = [];
        $cart = Cart::content();

        $i = 0;
        foreach ($cart as $item) {
            $cartArr[$i] = [
                'id' => (int)$item->id,
                'name' => $item->name,
                'price' => $item->price,
                'qty' => $item->qty,
                'variant_id' => $item?->options?->variant_id,
                'image' => $item->image
            ];
            $i++;
        }

        return $cartArr;
    }

    public function getTotalPriceDetails()
    {
        $total = 0.0;
        $cartArr = self::getCartProducts();

        foreach ($cartArr as $item) {
            $total += $item['price'] * $item['qty'];
            $products_id[] = $item['id'];
            $variant_id[] = $item['variant_id'];
            $quantity[] = $item['qty'];
            $price[] = $item['price'];
        }

        return [
            'total' => $total,
            'products_id' => $products_id,
            'variants_id' => $variant_id,
            'quantity' => $quantity,
            'price' => $price
        ];
    }

    public function getFinalPriceDetails($user, $validated_data)
    {
        $shipping_method = $validated_data['shipping_method'];
        $coupon = (object)[
            "coupon" => $validated_data['used_coupon']
        ];

        $price = $this->getTotalPriceDetails();
        $products = Product::whereIn('id' ,$price['products_id'])->get();

        $data = $this->get_product_shipping_tax(['country' => $user['country'], 'state' => $user['state'], 'shipping_method' => (int)$shipping_method]);
        $discounted_price = CheckoutCouponService::calculateCoupon($coupon, $price['total'], $products, 'DISCOUNT');

        $product_tax = $data['product_tax'];
        $shipping_cost = $data['shipping_cost'];

        $taxed_price = ($price['total'] * $product_tax) / 100;
        $subtotal = $price['total'];
        $total['total'] = $price['total'] + $taxed_price + $shipping_cost;

        $discount = $discounted_price != 0 ? $discounted_price : 0;
        if ($discounted_price > 0)
        {
            $total['total'] = $discount + $taxed_price + $shipping_cost;
            $total['cart_total'] = $price;
        }

        $total['payment_meta'] = $this->payment_meta(compact('product_tax', 'shipping_cost', 'subtotal', 'total'));

        return $total;
    }

    public function createOrder($validated_data, $user)
    {
        // Checking shipping method is selected
        if (!$this->check_shipping_method($user, $validated_data)) {
            return false;
        }

        $totalPriceDetails = $this->getTotalPriceDetails();
        $finalDetails = $this->getFinalPriceDetails($user, $validated_data);

        $finalPriceDetails = $finalDetails['total'];
        $payment_meta = $finalDetails['payment_meta'];
        $payment_gateway = $validated_data['payment_gateway'] ?? null;
        $extra_note = $validated_data['message'];
        $cart_data = json_encode(Cart::content()->toArray());

        $coupon = [];
        if (!empty($validated_data['used_coupon']))
        {
            $coupon['coupon'] = ProductCoupon::where('code', $validated_data['used_coupon'])->first();
            $coupon['coupon_code'] = $coupon['coupon']->code;
            $coupon['coupon_discount'] = $coupon['coupon']->discount;
        }

        $order_id = ProductOrder::create([
            'user_id' => $user['id'] ?? null,
            'name' => $user['name'],
            'email' => $user['email'],
            'phone' => $user['mobile'],
            'country' => $user['country'],
            'state' => $user['state'],
            'city' => $user['city'],
            'address' => $user['address'],
            'message' => $extra_note,
            'coupon' => !empty($coupon) ? $coupon['coupon_code'] : '',
            'coupon_discounted' => !empty($coupon) ? $coupon['coupon_discount'] : '',
            'total_amount' => $finalPriceDetails,
            'payment_gateway' => $payment_gateway,
            'status' => 'pending',
            'payment_status' => 'pending',
            'checkout_type' => $validated_data['checkout_type'],
            'payment_track' => Str::random(10) . Str::random(10),
            'order_details' => $cart_data,
            'payment_meta' => $payment_meta,
            'selected_shipping_option' => $validated_data['shipping_method'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ])->id;

        foreach ($totalPriceDetails['products_id'] as $key => $ids)
        {
            $products = Product::whereIn('id', $totalPriceDetails['products_id'])->get();
            $coupon = (object)[
                "coupon" => $validated_data['used_coupon']
            ];

            if (in_array('cart_total', $finalDetails))
            {
                $coupon_type_info = CheckoutCouponService::calculateCoupon($coupon , $finalDetails['cart_total'], $products, return_type: 'TOTAL',  purpose: 'type');
                $price = $this->coupon_based_products($coupon_type_info, $ids, $totalPriceDetails['quantity'][$key]);
            }

            OrderProducts::create([
                'order_id' => $order_id,
                'product_id' => $totalPriceDetails['products_id'][$key],
                'variant_id' => !empty($totalPriceDetails['variants_id'][$key]) ? $totalPriceDetails['variants_id'][$key] : null,
                'quantity' => $totalPriceDetails['quantity'][$key] ?? null,
                'price' => $price ?? $totalPriceDetails['price'][$key]
            ]);
        }

        return $order_id;
    }

    public function coupon_based_products($coupon_type_info, $product_id, $qty)
    {
        $product = Product::where('id', $product_id)->first();

        if ($coupon_type_info['discount_on'] == 'all') {
            $price = $this->discount_type_based_price(price: $product->sale_price, discount_amount: $coupon_type_info['coupon_amount'], discount_type: $coupon_type_info['coupon_type'], qty: $qty);
        } elseif ($coupon_type_info['discount_on'] == 'category') {
            $categories = (array) json_decode($coupon_type_info['coupon_object']->discount_on_details);
            $category = (int) $categories[0];

            $product_ids = ProductCategory::where('category_id', $category)->pluck('product_id');
            if (in_array($product->id, current($product_ids)))
            {
                $price = $this->discount_type_based_price(price: $product->sale_price, discount_amount: $coupon_type_info['coupon_amount'], discount_type: $coupon_type_info['coupon_type'], qty: $qty);
            }
        } elseif ($coupon_type_info['discount_on'] == 'subcategory') {
            $sub_categories = (array) json_decode($coupon_type_info['coupon_object']->discount_on_details);
            $sub_category = (int) $sub_categories[0];

            $product_ids = ProductSubCategory::where('sub_category_id', $sub_category)->pluck('product_id');
            if (in_array($product->id, current($product_ids)))
            {
                $price = $this->discount_type_based_price(price: $product->sale_price, discount_amount: $coupon_type_info['coupon_amount'], discount_type: $coupon_type_info['coupon_type'], qty: $qty);
            }

        } elseif ($coupon_type_info['discount_on'] == 'childcategory') {
            $child_categories = (array) json_decode($coupon_type_info['coupon_object']->discount_on_details);
            $child_category = (int) $child_categories[0];

            $product_ids = ProductChildCategory::where('child_category_id', $child_category)->pluck('product_id');
            if (in_array($product->id, current($product_ids)))
            {
                $price = $this->discount_type_based_price(price: $product->sale_price, discount_amount: $coupon_type_info['coupon_amount'], discount_type: $coupon_type_info['coupon_type'], qty: $qty);
            }

        } elseif ($coupon_type_info['discount_on'] == 'product') {
            $product_ids = (array) json_decode($coupon_type_info['coupon_object']->discount_on_details);

            if (count($product_ids) < 1) {
                return 0;
            }

            if(in_array($product->id, $product_ids)){
                $price = $this->discount_type_based_price(price: $product->sale_price, discount_amount: $coupon_type_info['coupon_amount'], discount_type: $coupon_type_info['coupon_type'], qty: $qty);
            }
        }

        return $price;
    }

    private function discount_type_based_price($price, $discount_amount, $discount_type, $qty)
    {
        $price = $price * $qty;
        if ($discount_type == 'percentage')
        {
            return $price - ($price * $discount_amount) / 100;
        } else {
            return $price - $discount_amount;
        }
    }

    private function get_product_shipping_tax($request)
    {
        $shipping_cost = 0;
        $product_tax = 0;

        if ($request['state'] && $request['country']) {
            $product_tax = StateTax::where(['country_id' => $request['country'], 'state_id' => $request['state']])->select('id', 'tax_percentage')->first();

            if (empty($product_tax))
            {
                $product_tax = CountryTax::where('country_id', $request['country'])->select('id', 'tax_percentage')->first();
            }

            if ($product_tax) {
                $product_tax = $product_tax->toArray()['tax_percentage'];
            }
        } else {
            $product_tax = CountryTax::where('country_id', $request['country'])->select('id', 'tax_percentage')->first();
            if ($product_tax) {
                $product_tax = $product_tax->toArray()['tax_percentage'];
            }
        }

        $shipping = ShippingMethod::find($request['shipping_method']);
        $shipping_option = $shipping->options ?? null;

        if ($shipping_option != null && $shipping_option?->tax_status == 1) {
            $shipping_cost = $shipping_option?->cost + (($shipping_option?->cost * $product_tax) / 100);
        } else {
            $shipping_cost = $shipping_option?->cost;
        }

        $data['product_tax'] = $product_tax;
        $data['shipping_cost'] = $shipping_cost;

        return $data;
    }

    private function payment_meta($data)
    {
        $meta = [
            'shipping_cost' => $data['shipping_cost'],
            'product_tax' => $data['product_tax'],
            'subtotal' => $data['subtotal'],
            'total' => current($data['total'])
        ];

        return json_encode($meta);
    }

    private function check_shipping_method($user, $data) // Checking shipping method is selected
    {
        $shipping = ZoneRegion::whereJsonContains('state', (string)$user['state'])->first();
        if (empty($shipping)) {
            $shipping = ZoneRegion::whereJsonContains('country', (string)$user['country'])->first();
        }

        if (!empty($shipping)) {
            $method = ShippingMethod::where("zone_id", $shipping->zone_id)->count();

            if ($method > 0 && empty($data["shipping_method"])) {
                return false;
            }
        }

        return true;
    }
}
