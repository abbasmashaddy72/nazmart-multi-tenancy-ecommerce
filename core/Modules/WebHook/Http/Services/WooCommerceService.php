<?php

namespace Modules\WebHook\Http\Services;

use App\Enums\ProductTypeEnum;
use App\Enums\StatusEnums;
use App\Http\Services\HandleImageUploadService;
use Automattic\WooCommerce\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class WooCommerceService
{
    private Client $woocommerce_client;
    const image_path = 'assets/uploads/temp-images/';

    public function __construct()
    {
        $site_url = get_static_option('woocommerce_site_url') ?? '';
        $consumer_key = get_static_option('woocommerce_consumer_key') ?? '';
        $consumer_secret = get_static_option('woocommerce_consumer_secret') ?? '';

        $this->woocommerce_client = new Client($site_url, $consumer_key, $consumer_secret, ['version' => 'wc/v3']);
    }

    public function getProducts()
    {
        return $this->woocommerce_client->get('products');
    }

    public function prepareProducts($products)
    {
        $count = 0;
        $productArr = [];
        foreach ($products ?? [] as $product)
        {
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

            $image = current($product->images);
            $temp_image_data = $this->downloadImageFromURL($image->src, $image->name);
            $this->uploadImage($temp_image_data);


            $count++;
        }

        dd($productArr);
    }

    public function downloadImageFromURL($url, $file_name = 'image'): array
    {
        $image_url = $url;
        $image_data_arr = explode('.', $file_name);
        $image_name = current($image_data_arr);
        $image_extension = last($image_data_arr);

        // Fetch the image content
        $image_content = file_get_contents($image_url);

        // Generate a unique filename for the stored image
        $unique_filename = uniqid($image_name.'-');
        $unique_filename_with_extension = $unique_filename.'.'.$image_extension;
        $store_path = 'assets/uploads/temp-images/'.$unique_filename_with_extension;

        try {
            file_put_contents($store_path, $image_content);
            $status = true;
        } catch (\Exception $exception) {
            $status = false;
        }

        return $status ? [
            'status' => true,
            'image_name' => $unique_filename_with_extension,
            'image_name_extension' => $unique_filename_with_extension,
            'image_object' => $this->getImageAsObject($unique_filename_with_extension)
        ] : ['status' => false];
    }

    public function uploadImage($file_data): bool
    {
        if ($file_data['status'])
        {
            $image_name = $file_data['image_name'];
            $image_object = $file_data['image_object'];
            $image_name_with_extension = $file_data['image_name_extension'];
            $folder_path = global_assets_path('assets/tenant/uploads/media-uploader/'.tenant()->id.'/');
            $request['file'] = $image_object;
            $request['user_type'] = 'admin';
            $request = (object) $request;

//            try {
                $uploaded = HandleImageUploadService::handle_image_upload
                (
                    $image_name,
                    $image_object,
                    $image_name_with_extension,
                    $folder_path,
                    $request,

                );
//            } catch (\Exception $exception) {
//                $uploaded = false;
//            }

            return $uploaded;
        }

        return false;
    }

    private function getImageAsObject($image_name): ?UploadedFile
    {
        $file = null;
        $path = self::image_path.$image_name;
        if (file_exists($path))
        {
            $file = new UploadedFile($path, $image_name);
        }

        return $file;
    }
}
