<?php

namespace App\Traits;

use App\Image;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as IntImage;

trait ImageProcessing
{ 
    /**
     * Process image payload... Upload, Update or Delete
     * 
     * @author Tony Ayeni <tonyfrenzy@gmail.com>
     */

    # This method targets user avatar uploads only.
    public function avatarProcessing(Request $request, $model)
    {
        $model_frags    = explode('\\', get_class($model));
        $modelClassName = end($model_frags);
        $unique_time    = time(); 

        $image_file = $request->file('avatar');


        // $uploadModelImage = '\App\Jobs\\Upload'. $modelClassName .'Image';

        // $this->authorize('upload', $model);

        if ($request->file('avatar')) {
            request()->validate([
                'avatar' => 'required|file|image|max:2000|mimes:jpeg,png|dimensions:min_width=200,min_height=200',
            ],
            [
                'avatar.mimes' => 'Only jpeg and png formats are allowed.',
                'avatar.dimensions' => 'Your image dimensions must have a minimum width of 200px and minimum height of 200px.',
            ]);

            $this->imageDeleteTrait($request, $model);
                
            $unique_id = uniqid();

            $this->resizeImage($model, $image_file, $modelClassName, $unique_time, $unique_id);

            ## Move to storage provider by job.
            // $this->dispatch(new $uploadModelImage($model, $filename));
            // $this->dispatch(new $uploadModelImage($model, $file_md));
            // $this->dispatch(new $uploadModelImage($model, $file_tb));

            $this->saveImageInfo($request, $model, $modelClassName, $unique_time, $unique_id);
        }
            
        return;
    }

    # Works for every other models
    public function imageProcessing(Request $request, $model)
    {
        $model_frags    = explode('\\', get_class($model));
        $modelClassName = end($model_frags); 
        $unique_time    = time();

        // $uploadModelImage = '\App\Jobs\\Upload'. $modelClassName .'Image';

        // $this->authorize('upload', $model);

        if ($request->file('image_file')) {
            request()->validate([
                'image_file' => 'required|array|max:5',
                'image_file.*'=> 'required|file|image|max:2000|mimes:jpeg,png|dimensions:min_width=300,min_height=300',
                'caption'   => 'required_with:image_file|string|max:255',
            ],
            [
                'image_file.mimes' => 'Only jpeg and png formats are allowed.',
                'image_file.dimensions' => 'Your image dimensions must have a minimum width of 300px and minimum height of 300px.',
                'image_file.*.dimensions' => 'All images must have a minimum width: 300px and minimum height: 300px.',
                'image_file.*.max' => 'Image size must be a maximum of 2mb.',
            ]);

            $uploads_count = count($request->file('image_file'));
            
            foreach ($request->file('image_file') as $image_file) 
            {
                $unique_id = uniqid();

                $this->resizeImage($model, $image_file, $modelClassName, $unique_time, $unique_id);

                ## Move to storage provider by job.
                // $this->dispatch(new $uploadModelImage($model, $filename));
                // $this->dispatch(new $uploadModelImage($model, $file_md));
                // $this->dispatch(new $uploadModelImage($model, $file_tb))

                $this->saveImageInfo($request, $model, $modelClassName, $unique_time, $unique_id);
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
    public function resizeImage($model, $image_file, $modelClassName, $unique_time, $unique_id) 
    {
        # Set basename for file.
        $filename = $model->slug 
                          ? $model->slug .'-'. $unique_time . $unique_id
                          : md5(strval($model->id)) .'-'. $unique_time . $unique_id
                          ;
        $directory = public_path() .'/uploads/images/'. strtolower(str_plural($modelClassName)); 

        # Once processed and moved to storage, image file is no more available 
        # thus the need to hold as much as is needed with different variable names.
        $image_file_tb = $image_file;
        $image_file_md = $image_file;

        # Save to disk (temporarily)
        // Make Thumbnail:
        IntImage::make($image_file_tb)
                ->fit(180)//resize(150,150, function($constraint){ $constraint->aspectRatio(); })
                ->save($directory .'/'. $filename .'-tb.png');

        // Make Medium:
        IntImage::make($image_file_md)
                ->resize(400,400, function($constraint){ $constraint->aspectRatio(); })
                ->save($directory .'/'. $filename .'-md.png');

        // Move Original:
        $image_file->move($directory .'/', $filename . '.png');
        
        return;
    }

    /**
     * Save image url links to the IMAGES Table.
     *
     * Saving to storage provider eg S3, dropbox is done inside $uploadModelImage($model, $filename)
     */
    public function saveImageInfo(Request $request, $model, $modelClassName, $unique_time, $unique_id) 
    {
        # Set basename for file.
        $filename = $model->slug 
                        ? $model->slug .'-'. $unique_time . $unique_id 
                        : md5(strval($model->id)) .'-'. $unique_time . $unique_id
                        ;
        $directory = config('filesystems.storage.images') 
                        . '/'. strtolower(str_plural($modelClassName))
                        ;
        $image_location    = $directory .'/'. $filename .    '.png';
        $image_md_location = $directory .'/'. $filename . '-md.png';
        $image_tb_location = $directory .'/'. $filename . '-tb.png';
        
        
        if ($request->file('avatar')) {
            $user = auth()->user();
            $user->avatar = config('app.url') . $image_tb_location;
            $user->save();
        }

        $image = New Image;

        $image->user_id        = auth()->id();
        $image->url            = $image_location;
        $image->cover          = ! $model->images->count() ? '1':'0';
        $image->medium_url     = $image_md_location;
        $image->thumbnail_url  = $image_tb_location;
        $image->caption        = $request->caption;
        $image->imageable_id   = $model->id;
        $image->imageable_type = get_class($model);

        $model->images()->save($image);

        return;
    }

    public function imageUploadTrait(Request $request, $model)
    {
        $this->imageProcessing($request, $model);

        return;
    }

    /**
     * Image delete is a two/three-step process
     *
     * 1. Delete from Storage disk
     * 2. Delete reference url link and general info from Images table in DB.
     * 3. Delete reference url link from Users table's avatar field in DB.
     *
     * @param $request
     * @param $model
     * @return void
     */
    public function imageDeleteTrait(Request $request, $model)
    {
        $model_frags    = explode('\\',get_class($model));
        $modelClassName = end($model_frags); 

        $storage_directory = public_path() .'/uploads/images/'. strtolower(str_plural($modelClassName)) .'/';

        if (($modelClassName == 'User') && $model->avatar) {
            if ($model->images()->first()) {

              #1. Remove file(s) from Storage disk.
               // Get avatar's filename. eg. john-doe-12345-tb.png
                $avatar_frags   = explode('/', $model->avatar);
                $_avatar        = end($avatar_frags);

               // Get actual avatar's filename without mime. eg. john-doe-12345
                $_avatar_frags  = explode('-tb', $_avatar);
                reset($_avatar_frags);
                    $original_file = current($_avatar_frags);

               // Append respective resized names eg. john-doe-12345-md.png
                $_avatar_md     = $original_file . '-md.png';
                $_avatar_or     = $original_file .    '.png';

                $image      = $storage_directory . $_avatar_or; 
                $image_md   = $storage_directory . $_avatar_md; 
                $image_tb   = $storage_directory . $_avatar; 

               # Remove from STORAGE by leveraging queue jobs for faster user experience.
                // $removeModelAvatar = '\App\Jobs\\'. $modelClassName .'RemoveAvatar';
                // $this->dispatch(new $removeModelAvatar($model, $image));
                // $this->dispatch(new $removeModelAvatar($model, $image_md));
                // $this->dispatch(new $removeModelAvatar($model, $image_tb));

               # Perform actual removal from STORAGE
                File::delete($image, $image_md, $image_tb); // unlink($image_tb);


              #2. Remove reference link from Images Table
                $model->images()->first()
                       ? $model->images()->first()->delete()
                       : false
                       ;

              #3. Remove reference link from avatar field in Users Table
                // $model->avatar_thumbnail_url = null;
                $model->avatar = null;
                $model->save();
            }
        }

        // #1. Remove image and resizes from disk.
        // #2. Remove reference link from Images table in the database
        // // Image::where('imageable_id', $model->id)
        // //      ->where('imageable_type', get_class($model)
        // //      ->first()
        // //      ->delete();
        // $model->images()->find($request->image_id)->delete();

        // // if no $request->avatar then this is plain DELETE request
        // if (! $request->avatar){
        //     // Remove reference link from images table in the database
        //     $model->images()->first()->delete();

        //     // Remove reference link from users table in the database
        //     $model->avatar = null;
        //     $model->avatar_thumbnail_url = null;
        //     $model->save();
        // }

        return;
    }
}