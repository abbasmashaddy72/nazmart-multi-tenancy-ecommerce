<?php

namespace App\Jobs;

use App\Models\MediaUploader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SyncLocalFileWithCloud implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $file)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $files = ["grid/",'large/','thumb/','tiny/',''];
        $item = $this->file;

        foreach ($files as $vFile) {
            $prefix = '';
            if ($vFile != ''){
                $prefix = str_replace('/','',$vFile).'-';
            }

            //todo, run query from the database get all media file then run loop and send file to the jobs done it through queue, update database that this file is already synced
            $local_file_path = base_path("../assets/landlord/uploads/media-uploader/".$vFile.$prefix.$item?->path);

            $cl_file_path = $vFile.$prefix.$item?->path;

            // /* checking the file exits in locally or not, if not exits return this jobs. */
            if (empty($item->path)){
                return;
            }
            if (!file_exists($local_file_path)){
                return;
            }


            // //todo:: check the file already exists in the cloud if not exits then create then copy that file to cloud
            if (!Storage::drive("s3")->exists($cl_file_path)){
                $fileNeed =  new \Illuminate\Http\File($local_file_path);
                //todo: have to check for three file
                Storage::drive("s3")->putFileAs("/".$vFile,$fileNeed,$prefix.$item->path);
                MediaUploader::find($item->id)->update(["is_synced" => 1,'load_from' => 1]);

            }

            /* change the database status to is_synced because the file is already exits on the cloud */
            MediaUploader::find($item->id)->update(["is_synced" => 1,'load_from' => 1]);
        }
    }
}
