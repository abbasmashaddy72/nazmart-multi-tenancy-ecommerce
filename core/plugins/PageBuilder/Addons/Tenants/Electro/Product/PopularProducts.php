<?php

namespace Plugins\PageBuilder\Addons\Tenants\Electro\Product;

use App\Enums\StatusEnums;
use App\Helpers\SanitizeInput;
use App\Models\OrderProducts;
use Illuminate\Support\Facades\DB;
use Modules\Attributes\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\NiceSelect;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Select;
use Plugins\PageBuilder\Fields\Switcher;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\PageBuilderBase;

class PopularProducts extends PageBuilderBase
{
    public function preview_image()
    {
        return 'Tenant/common/brand-01.png';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();
        $widget_saved_values = $this->get_settings();

        $output .= Text::get([
            'name' => 'title',
            'label' => __('Section Title'),
            'value' => $widget_saved_values['title'] ?? null,
        ]);

        $products = [];
        Product::published()->chunk(50, function ($chunked_products) use (&$products) {
            foreach ($chunked_products as $product)
            {
                $products[$product->id] = $product->name;
            }

            return $products;
        });

//        $products_id = OrderProducts::query()->distinct('product_id')->orderBy('product_id', 'desc')->pluck('product_id')->toArray();
//        $sales = DB::table('order_products')
//            ->leftJoin('products','order_products.product_id','=','products.id')
//            ->selectRaw('order_products.*, COALESCE(sum(order_products.product_id),0) total')
//            ->groupBy('order_products.product_id')
//            ->orderBy('total','desc')
//            ->take(5)
//            ->get();

//        $referrals = OrderProducts::whereNotNull('product_id')->orderBy('product_id', 'asc')->get()->groupBy('product_id');

        $users = OrderProducts::select('*', DB::raw('count(product_id) as total'))
            ->groupBy('product_id')
            ->pluck('product_id','total')
            ->orderBy('total', 'desc')
            ->toArray();

        $users = DB::table('order_products')->raw("SELECT COUNT(CustomerID), Country
                                FROM Customers
                                GROUP BY Country
                                ORDER BY COUNT(CustomerID) DESC");

        dd($users);


        $output .= NiceSelect::get([
            'multiple' => true,
            'name' => 'products',
            'label' => __('Select Products'),
            'options' => $products,
            'value' => $widget_saved_values['products'] ?? null,
            'info' => __('You can select your desired products or leave it empty to show latest products')
        ]);

        $output .= Number::get([
            'name' => 'item_show',
            'label' => __('Product Show'),
            'value' => $widget_saved_values['item_show'] ?? null,
            'info' => 'How many products will be shown'
        ]);

        $output .= Select::get([
            'name' => 'item_order',
            'label' => __('Product Order'),
            'options' => [
                'desc' => __('Descending'),
                'asc' => __('Ascending')
            ],
            'value' => $widget_saved_values['item_order'] ?? null,
            'info' => 'Product order, descending or ascending'
        ]);

        // add padding option
        $output .= $this->padding_fields($widget_saved_values);
        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $product_id = $this->setting_item('products');
        $title = SanitizeInput::esc_html($this->setting_item('title') ?? '');
        $item_show = SanitizeInput::esc_html($this->setting_item('item_show') ?? '');
        $item_order = SanitizeInput::esc_html($this->setting_item('item_order') ?? '');

        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));

        $products = Product::with('badge', 'campaign_product', 'inventory', 'inventoryDetail')
                    ->where('status_id', 1);

        if (!empty($product_id))
        {
            $products->whereIn('id', $product_id);
        }

        $products = $products->orderBy('created_at', $item_order ?? 'desc')->take($item_show ?? 4)->get();

        $data = [
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
            'title' => $title,
            'products'=> $products,
        ];

        return self::renderView('tenant.electro.product.featured-collection', $data);
    }

    public function addon_title()
    {
        return __('Electro: Popular Products');
    }
}
