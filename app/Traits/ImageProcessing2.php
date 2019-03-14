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
                $this->fileDelete( $model );
            }
            
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
    public function fileDelete( $model )
    {
        // dd($model);
        $modelFrags     = explode('\\',get_class($model));
        $modelClassName = strtolower(str_plural(end($modelFrags))); 

        $storage_directory = config('filesystems.behealthy.serve.' . $modelClassName) .'/';

        if (($modelClassName == 'users') && $model->hasUploadedAvatar()) {
            $documents = $model->documents()->get();
                    /*   $model->where('documentable_id', $model->id)
                               ->where('documentable_type', 'App\User')
                               ->get();
                    */
            foreach ($documents as $document) {
                # Remove file from STORAGE disk.
                $documentPath   = $storage_directory . $document->unique_id; 
                File::delete($documentPath);

                #2. Remove reference link from Documents Table
                $document->delete();
            }

            #3. Remove reference link from avatar field in Users Table
            $model->avatar = null;
            $model->save();
        }
        else {
            $document = 
                \App\Document::where('documentable_id', $model->id)
                    ->where('documentable_type', get_class($model))
                    ->first()
                    ;
            #1. Remove file from STORAGE disk.
            $documentPath   = $storage_directory . $document->unique_id; 
            File::delete($documentPath);

            #2. Remove reference link from Documents Table
            $document->delete();
        }

        // #1. Remove file from disk.
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