<?php

namespace Modules\WebHook\Http\Services;

use App\Enums\ProductTypeEnum;
use App\Enums\StatusEnums;
use Automattic\WooCommerce\Client;

class WooCommerceService
{
    public static function getWoocommerceClient(): Client
    {
        $site_url = get_static_option('woocommerce_site_url') ?? '';
        $consumer_key = get_static_option('woocommerce_consumer_key') ?? '';
        $consumer_secret = get_static_option('woocommerce_consumer_secret') ?? '';

        return new Client($site_url, $consumer_key, $consumer_secret, ['version' => 'wc/v3']);
    }

    public static function getProducts()
    {
        $products = self::getWoocommerceClient();
        return $products->get('products');
    }

    public static function prepareProducts($products)
    {
        $count = 0;
        $productArr = [];
        foreach ($products ?? [] as $product)
        {
            dd($products);
            if (count($product->variations) > 0)
            {
                continue;
            }

            $productArr[$count]['name'] = $product->name;
            $productArr[$count]['slug'] = $product->slug;
            $productArr[$count]['summary'] = preg_replace("/\r|\n/", "", $product->short_description);
            $productArr[$count]['description'] = preg_replace("/\r|\n/", "", $product->description);
            $productArr[$count]['categories'] = current($product->categories)->name;

            $productArr[$count]['cost'] = $product->price;
            $productArr[$count]['price'] = $product->regular_price ?? $product->price;
            $productArr[$count]['sale_price'] = $product->sale_price;

            $productArr[$count]['status_id'] = StatusEnums::PUBLISH;
            $productArr[$count]['product_type'] = ProductTypeEnum::PHYSICAL;


            $count++;
        }

        dd($productArr);
    }

    public function getImageFromURL()
    {

    }
}
