<?php

namespace Modules\WooCommerce\Http\Controllers;

use App\Helpers\FlashMsg;
use Automattic\WooCommerce\Client;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WebHook\Http\Services\WooCommerceService;

class WooCommerceController extends Controller
{
    public function index()
    {
        $api_products = new WooCommerceService();
        $all_products = $api_products->getProducts();
        $all_prepared_products = $api_products->prepareProducts($all_products);
        dd($all_prepared_products);

        return view('woocommerce::index');
    }

    public function settings()
    {
        return view('woocommerce::woocommerce.settings');
    }

    public function settings_update(Request $request)
    {
        $validated_data = $request->validate([
            'woocommerce_site_url' => 'required',
            'woocommerce_consumer_key' => 'required|starts_with:ck',
            'woocommerce_consumer_secret' => 'required|starts_with:cs'
        ],[
            'woocommerce_consumer_key.starts_with' => __('The consumer key is invalid'),
            'woocommerce_consumer_secret.starts_with' => __('The consumer secret is invalid'),
        ]);

        foreach ($validated_data ?? [] as $index => $value)
        {
            update_static_option($index, $value);
        }

        return back()->with(FlashMsg::settings_update('Woocommerce settings updated'));
    }
}
