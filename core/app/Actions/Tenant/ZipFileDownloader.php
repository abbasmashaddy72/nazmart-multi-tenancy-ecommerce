<?php

namespace App\Actions\Tenant;

class ZipFileDownloader
{
    public string $zip_file_location;
    public function __destruct()
    {

    }

    public function download($product)
    {
        $zip_file_name = time().'.zip';
        $this->zip_file_location = global_assets_path('assets/tenant/uploads/digital-product-file/'.tenant()->id.'/'.$zip_file_name);
        $zip_file_location = $this->zip_file_location;

        $zip = new \ZipArchive();

        if ($zip->open($zip_file_location, \ZipArchive::CREATE) === TRUE)
        {
            $real_file_path = global_assets_path('assets/tenant/uploads/digital-product-file/'.tenant()->id.'/'.$product->file);
            $zip->addFile($real_file_path, $product->file);
            $zip->close();
        }

        return response()->download($zip_file_location)->deleteFileAfterSend();
    }
}
