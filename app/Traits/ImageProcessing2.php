<?php

namespace App\Traits;

use App\Image;
use App\Jobs\UploadDocumentJob;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as IntImage;

trait ImageProcessing2
{ 
    /**
     * Process image payload... Upload, Update or Delete
     * 
     * @author Tony Ayeni <tonyfrenzy@gmail.com>
     */

    # Works for every other models
    public function imageProcessing2(Request $request, $model)
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
                $filename = $uploadFile->getClientOriginalName();
                // dd(
                //     $filename,
                //     storage_path () . config( 'filesystems.behealthy.save.local-storage.images.general' )
                // );

                // move to temp location
                # $jobRenamedFile = $uploadFile;
                $uploadFile->move(config( 'filesystems.behealthy.temporary.images.general' ), $filename);

                // upload to permanent storage
                #  dd(config( 'filesystems.behealthy.save.local-storage.images.general' ), 'Image uploaded!');
                // dd($filename, $uploadFile);

                $rq = $request->except('uploadFile'); // Make request data availble in Doc Uploads job class.
                $this->dispatch(new UploadDocumentJob( $model, $filename ));

                return redirect()->back();
                return response()->json(null, 200);
            } 
        }
            
        return;
    }







    public function imageUploadTrait(Request $request, $model)
    {
        $this->imageProcessing2($request, $model);

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