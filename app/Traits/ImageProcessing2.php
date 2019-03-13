<?php

namespace App\Traits;

use App\Image;
use App\Jobs\UploadDocumentJob;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as IntImage;
use App\Http\Requests\DocumentUploadRequest;

trait ImageProcessing2
{ 
    /**
     * Process image payload... Upload, Update or Delete
     * 
     * @author Tony Ayeni <tonyfrenzy@gmail.com>
     */

    # Works for every other models
    public function imageProcessing2(DocumentUploadRequest $request, $model)
    {
        $uploadFile      = $request->uploadFile;
        // dd($request->all(), $uploadFile, $model);

        $modelFrags      = explode('\\', get_class($model));
        $modelClassName  = strtolower(str_plural(end($modelFrags))); 
        $dynamicTempLink = 'filesystems.behealthy.temporary.'. $modelClassName;


        if ($uploadFile) {

            if ($modelClassName == 'users') {
                $this->imageDeleteTrait( $request, $model );
            }
            // dd($modelClassName, $request->all(), count($uploadFile), $uploadFile);
            
            foreach ($uploadFile as $newFile) {
                $filename = $newFile->getClientOriginalName();

                $newFile->move(config( $dynamicTempLink ), $filename);

                // upload to permanent storage
                $this->dispatch(new UploadDocumentJob( $model, $filename, $modelClassName ));

            } 
        }
        return redirect()->back();// return response()->json(null, 200);
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