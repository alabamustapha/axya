<?php

namespace App\Traits;

use App\Document;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileProcessing
{ 
    /**
     * Process Files Upload, Update or Delete
     * 
     * @author Tony Ayeni <tonyfrenzy@gmail.com>
     */

    # Works for every other models
    public function fileProcessing(Request $request, $model)
    {
        // dd('actual Processing');
        $model_frags    = explode('\\', get_class($model));
        $modelClassName = end($model_frags); 
        $unique_time    = time();
        $uploadFile   = $request->file('uploadFile');

        $uploads_count  = count($uploadFile);
        // $directory      = public_path() .'/uploads/documents/'. strtolower(str_plural($modelClassName));
        $directory      = config('filesystems.public.documents') .'/'. strtolower(str_plural($modelClassName)); 
        // $directory      = config('filesystems.storage.documents') .'/'. strtolower(str_plural($modelClassName));

        // $uploadModelFile = '\App\Jobs\\Upload'. $modelClassName .'File';

        // $this->authorize('upload', $model);

        if ($uploadFile) {

            if (! is_array($uploadFile)) {
                request()->validate([
                    'uploadFile' => 'required|array|max:5',
                ]);
            }

            request()->validate([
                    'uploadFile.*'=> 'required|file|file|max:2000|mimes:pdf,doc,docx',
                    'caption'   => 'required_with:uploadFile|string|max:255',
                ],
                [
                    'uploadFile.mimes' => 'Only pdf, doc and docx formats are allowed.',
                    'uploadFile.*.max' => 'File size must be a maximum of 2mb.',
                ]);


            // // Placed here so directory is created on when validation passes.
            // if (! is_dir($directory)){
            //     Storage::makeDirectory($directory);
            //     dd($directory, is_dir($directory));
            //     mkdir($directory);
            // }



            // if($uploadFile){
            //     $fileExtension = $uploadFile->getClientOriginalExtension();
            //     $name      = $appointment->slug .'_'. time() .'.'. $fileExtension;

            //     $path      = $uploadFile->storeAs( $directory, $name );
            //     $document->image_file = $name;
            // }


            
            foreach ($uploadFile as $uploaded_file) 
            {
                $unique_id    = uniqid();
                $uniqueString = $unique_time . $unique_id;

                $fileExtension= $uploaded_file->getClientOriginalExtension();

                $filename     = $model->slug 
                                  ? $model->slug .'-'. $uniqueString
                                  : md5(strval($model->id)) .'-'. $uniqueString
                                  ;

                $fullFilename = $filename . '.' . $fileExtension;
                // // $directory = public_path() .'/uploads/files/'. strtolower(str_plural($modelClassName)); 

                ## Move Original:
                // $uploaded_file->move($directory .'/', $filename . '.png');
                $uploaded_file->storeAs( $directory, $fullFilename );

                ## Move to storage provider by job.
                // $this->dispatch(new $uploadModelFile($model, $filename));

                $this->saveFileInfo($request, $model, $uploaded_file, $modelClassName, $uniqueString);
            } 
        }
            
        return;
    }

    /**
     * Save file url links to the IMAGES Table.
     *
     * Saving to storage provider eg S3, dropbox is done inside $uploadModelFile($model, $filename)
     */
    public function saveFileInfo(Request $request, $model, $uploaded_file, $modelClassName, $uniqueString) 
    {
        // dd('save info');

        # Get file extension.
        $fileExtension = $uploaded_file->getClientOriginalExtension();

        # Set a new name for file.
        $filename  = $model->slug 
                        ? $model->slug .'-'. $uniqueString 
                        : md5(strval($model->id)) .'-'. $uniqueString
                        ;
        $directory = config('filesystems.storage.files') 
                        . '/'. strtolower(str_plural($modelClassName))
                        ;

        // $file_location    = $directory .'/'. $filename .    '.png';
        $file_location    = $directory .'/'. $filename . '.' . $fileExtension;

        // Save details to DB.
        $file = New Document;

        $file->user_id           = auth()->id();
        $file->url               = $file_location;
        $file->name              = $request->name;
        $file->description       = $request->description;
        $file->documentable_id   = $model->id;
        $file->documentable_type = get_class($model);
        $file->mime              = $fileExtension;
        $file->size              = $uploaded_file->getSize();

        // This document belongsto a Message model? morphOne!
        (get_class($model) == 'App\Message') 
            ? $model->document()->save($file)
            : $model->documents()->save($file)
            ;
        // dd($model->document->description);

        return;
    }

    public function fileUploadTrait(Request $request, $model)
    {
        $this->fileProcessing($request, $model);

        return;
    }

    /**
     * File delete is a two/three-step process
     *
     * 1. Delete from Storage disk
     * 2. Delete reference url link and general info from Files table in DB.
     * 3. Delete reference url link from Users table's avatar field in DB.
     *
     * @param $request
     * @param $model
     * @return void
     */
    public function fileDeleteTrait(Request $request, $model)
    {
        $model_frags    = explode('\\',get_class($model));
        $modelClassName = end($model_frags); 

        $storage_directory = public_path() .'/uploads/files/'. strtolower(str_plural($modelClassName)) .'/';

        if (($modelClassName == 'User') && $model->avatar) {
            if ($model->files()->first()) {

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

                $file      = $storage_directory . $_avatar_or; 
                $file_md   = $storage_directory . $_avatar_md; 
                $file_tb   = $storage_directory . $_avatar; 

               # Remove from STORAGE by leveraging queue jobs for faster user experience.
                // $removeModelAvatar = '\App\Jobs\\'. $modelClassName .'RemoveAvatar';
                // $this->dispatch(new $removeModelAvatar($model, $file));
                // $this->dispatch(new $removeModelAvatar($model, $file_md));
                // $this->dispatch(new $removeModelAvatar($model, $file_tb));

               # Perform actual removal from STORAGE
                File::delete($file, $file_md, $file_tb); // unlink($file_tb);


              #2. Remove reference link from Files Table
                $model->files()->first()
                       ? $model->files()->first()->delete()
                       : false
                       ;

              #3. Remove reference link from avatar field in Users Table
                // $model->avatar_thumbnail_url = null;
                $model->avatar = null;
                $model->save();
            }
        }

        // #1. Remove file and resizes from disk.
        // #2. Remove reference link from Files table in the database
        // // File::where('documentable_id', $model->id)
        // //      ->where('documentable_type', get_class($model)
        // //      ->first()
        // //      ->delete();
        // $model->files()->find($request->file_id)->delete();

        // // if no $request->avatar then this is plain DELETE request
        // if (! $request->avatar){
        //     // Remove reference link from files table in the database
        //     $model->files()->first()->delete();

        //     // Remove reference link from users table in the database
        //     $model->avatar = null;
        //     $model->avatar_thumbnail_url = null;
        //     $model->save();
        // }

        return;
    }
}