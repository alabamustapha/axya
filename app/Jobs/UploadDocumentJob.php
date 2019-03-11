<?php

namespace App\Jobs;

use File;
use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;
    public $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $filename)
    {
        $this->model    = $model;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path          = config( 'filesystems.behealthy.temporary.images.general' ) . $this->filename;
        $fStoragePath  = config( 'filesystems.behealthy.save.local-storage.images.general' ) . $this->filename;
        $fileExtension = File::extension($path);
        $unique_time   = time();
        $newFilename   = uniqid('', true) . $unique_time;
        // dd($path, $targetPath, $fileExtension, $newFilename);

        /** 
         ## Move to the permanent storage location.
         * 
         * if ( Storage::disk('s3Videos')->put(...)) {};
         * A sub for the 3rd-party storage service used instead.
         */
        if ( Storage::disk('local')->put($fStoragePath . $this->filename, $handler = fopen($path, 'r+')) ) {  
            // delete from local.
            fclose($handler);
            File::delete($path);
        }
    }

    # Works for every other models
    public function imageProcessing(Request $request, $model)
    {
        // dd('actual Processing');
        $model_frags    = explode('\\', get_class($model));
        $modelClassName = end($model_frags); 
        $unique_time    = time();

        // $uploadModelImage = '\App\Jobs\\Upload'. $modelClassName .'Image';

        // $this->authorize('upload', $model);

        if ($request->file('uploadFile')) {

            if (! is_array($request->file('uploadFile'))) {
                request()->validate([
                    'uploadFile' => 'required|array|max:5',
                ]);
            }

            request()->validate([
                // ...\vendor\fzaninotto\faker\src\Faker\Provider\File.php:$mimeTypes
                'uploadFile.*'=> 'required|file|image|max:2000|mimes:jpeg,png|dimensions:min_width=300,min_height=300',
                'caption'   => 'required_with:uploadFile|string|max:255',
            ],
            [
                'uploadFile.mimes' => 'Only jpeg and png formats are allowed.',
                'uploadFile.dimensions' => 'Your image dimensions must have a minimum width of 300px and minimum height of 300px.',
                'uploadFile.*.dimensions' => 'All images must have a minimum width: 300px and minimum height: 300px.',
                'uploadFile.*.max' => 'Image size must be a maximum of 2mb.',
            ]);


            $uploads_count = count($request->file('uploadFile'));
            
            foreach ($request->file('uploadFile') as $uploadFile) 
            {
                $unique_id = uniqid();

                # Get file size and save to db - Helps get total space taken by files anytime later.
                $fileSize = IntImage::make($uploadFile)->filesize();

                $this->resizeImage($request, $model, $uploadFile, $modelClassName, $unique_time, $unique_id);

                ## Move to storage provider by job.
                // $this->dispatch(new $uploadModelImage($model, $filename));
                // $this->dispatch(new $uploadModelImage($model, $file_md));
                // $this->dispatch(new $uploadModelImage($model, $file_tb))

                $this->saveImageInfo($request, $model, $uploadFile, $fileSize, $modelClassName, $unique_time, $unique_id);
            } 
        }
            
        return;
    }

    /**
     * Create different resizes and save to local disk.
     * Image can be moved to external storage server when necessary.
     *
     * Saving to storage provider (eg S3, dropbox) is done within $uploadModelImage($model, $filename)
     */
    public function resizeImage(Request $request, $model, $uploadFile, $modelClassName, $unique_time, $unique_id) 
    {
        // dd('resize script');
        # Set basename for file.
        $filename = $model->slug 
                          ? $model->slug .'-'. $unique_time . $unique_id
                          : md5(strval($model->id)) .'-'. $unique_time . $unique_id
                          ;
        $directory = public_path() . config('filesystems.storage.images') . strtolower(str_plural($modelClassName)); 

        if (! $request->no_resize) {
            # Once processed and moved to storage, image file is no more available 
            # thus the need to hold as much as is needed with different variable names.
            $uploadFile_tb = $uploadFile;
            $uploadFile_md = $uploadFile;

            # Save to disk (temporarily)
            // Make Thumbnail:
            IntImage::make($uploadFile_tb)
                    ->fit(180)//resize(150,150, function($constraint){ $constraint->aspectRatio(); })
                    ->save($directory .'/'. $filename .'-tb.png');

            // Make Medium:
            IntImage::make($uploadFile_md)
                    ->resize(400,400, function($constraint){ $constraint->aspectRatio(); })
                    ->save($directory .'/'. $filename .'-md.png');
        }

        $fullFilename = $filename . '.png';

        ## Move Original:
        // $uploadFile->storeAs( $path, $fullFilename );
        $uploadFile->move($directory .'/', $fullFilename);
        
        return;
    }
    public function resizeImage2()
    {
        ## Get the image
        $path     = storage_path() . '/uploads/' . $this->fileId;
        $fileName = $this->fileId . '.png';

        ## Resize: With every new update to a job script always restart the console not just "queue:work".
        Image::make($path)->encode('png')->fit(140, 140, function ($c) {
            $c->upsize();
        })->save();

        /** 
         ## Move to the permanent storage location.
         * 
         * if ( Storage::disk('s3')->put(...)) {};
         * A sub for the 3rd-party storage service used instead.
         */
        if ( Storage::disk('local')->put( config('filesystems.codetube.save.local-buckets.images.channel') . $fileName, $handler = fopen($path, 'r+')) ) {  
            // delete from local.
            fclose($handler);
            File::delete($path);
        }

        ## Update channel image, ...moved to Controller...not working here, WIERD!!!
        $uploadedPath = config('filesystems.codetube.serve.local-buckets.images.channel') . $fileName;
        $this->channel->update(['image_filename' => $uploadedPath]);
    }

    /**
     * Save image url links to the IMAGES Table.
     *
     * Saving to storage provider eg S3, dropbox is done inside $uploadModelImage($model, $filename)
     */
    public function saveImageInfo(Request $request, $model, $uploadFile, $fileSize, $modelClassName, $unique_time, $unique_id) 
    {
        // dd('save info');
        # Set basename for file.
        $filename = $model->slug 
                        ? $model->slug .'-'. $unique_time . $unique_id 
                        : md5(strval($model->id)) .'-'. $unique_time . $unique_id
                        ;
        $directory = config('filesystems.storage.images') . strtolower(str_plural($modelClassName));

        if ($request->no_resize) {

            $image_location    = $directory .'/'. $filename .    '.png';
            
        } else {

            $image_location    = $directory .'/'. $filename .    '.png';
            $image_md_location = $directory .'/'. $filename . '-md.png';
            $image_tb_location = $directory .'/'. $filename . '-tb.png';

        }
        
        
        if ($request->file('avatar')) {
            $user = auth()->user();
            $user->avatar = config('app.url') . $image_tb_location;
            $user->save();
        }

        $fileExtension = $request->file('avatar') 
                        ? $request->file('avatar')->getClientOriginalExtension()
                        : $uploadFile->getClientOriginalExtension()
                        ;

        $image = New Image;

        $image->user_id        = auth()->id();
        $image->url            = $image_location;
        // $image->name           = $uploadFile->getClientOriginalName();
        $image->caption        = $request->caption;
        $image->imageable_id   = $model->id;
        $image->imageable_type = get_class($model);
        $image->mime           = $fileExtension;
        $image->size           = $fileSize;

        if (! $request->no_resize) {
            $image->cover          = $request->file('avatar') ? (! $model->images->count() ? '1':'0'):false;
            $image->medium_url     = $image_md_location;
            $image->thumbnail_url  = $image_tb_location;
        }

        (get_class($model) == 'App\Message') 
            ? $model->image()->save($image)
            : $model->images()->save($image)
            ;
        // dd($model->images()->first()->caption);

        return;
    }
}
