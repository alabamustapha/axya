<?php

namespace App\Jobs;

use File;
use Storage;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\ImageManagerStatic as IntImage;

class UploadDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;
    public $filename;
    public $path;
    public $finalStoragePath;
    public $renderStoragePath;
    public $fileExtension;
    public $uniqueFilename;
    public $resizes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $model, $filename )
    {
        $this->model            = $model;
        $this->filename         = $filename;
        $this->path             = config( 'filesystems.behealthy.temporary.images.general' ) . $this->filename;
        $this->fileExtension    = strtolower(File::extension($this->path));
        $this->uniqueFilename   = str_replace('.', '', uniqid('', true) . time());

        $this->finalStoragePath = config( 'filesystems.behealthy.save.local-storage.images.general' );
        $this->renderStoragePath= config( 'filesystems.behealthy.serve.local-storage.images.general' );

        $this->resizes =  [
            'tb' => [150, 250],
            'md' => [400, 400]
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        // dd($request->all(), $this->model, $this->filename);
        // dd(
        //     'Name: '. File::name($this->path),
        //     'BaseName: '. File::basename($this->path),
        //     'DirName: '. File::dirname($this->path)
        // );

        /*
            // foreach ($this->resizes as $k => $v) {
            // // list($a, $b) = $resize[$k];
            //     $var = list($name, $w, $h) = array($k, $v['0'], $v[1]);
            //     dd($var, $name, $w, $h);
            // }
        */

        /** 
         ## Move to the permanent storage location.
         * 
         * if ( Storage::disk('s3Videos')->put(...)) {};
         * A sub for the 3rd-party storage service used instead.
         */
        $resizedFinalStoragePath  = $this->finalStoragePath . $this->uniqueFilename .'.'. $this->fileExtension;
        $resizedRenderStoragePath = $this->renderStoragePath . $this->uniqueFilename .'.'. $this->fileExtension;

        if ( Storage::disk('local')->put($resizedFinalStoragePath, $handler = fopen($this->path, 'r+')) ) {  
            ## Add document details to 'documents' table.
            $this->saveDocumentInfo( $request );

            if ($request->no_resize /*|| $fileNotImage*/) {
                // delete from temporary local storage.
                fclose($handler);
                File::delete($this->path);
            }
            else {                
                $i = 0;
                foreach ($this->resizes as $key => $val) {
                    $resize 
                        = list($name, $width, $height) 
                            = array($key, $val['0'], $val[1]);
                    // dd($name, $width, $height);

                    $this->resizeImage2( $request, $resize );
                    $i++;

                    // If last resize, 
                    if ($i == sizeof($this->resizes)) {
                        fclose($handler);
                        File::delete($this->path);
                        // dd('Last loop: '. $i .'. Job done, Kudos!!!');
                    }
                }
            }
        }
    }

    public function resizeImage2( Request $request, $resize )
    {
        // dd($resize, 'Name: '.$resize[0], 'Width: '. $resize[1], 'Height: '. $resize[2]);

        $resizeSuffix = $resize[0];
        $width        = $resize[1];
        $height       = $resize[2];

        $resizedPath         = $this->path;
        $resizedFinalStoragePath = $this->finalStoragePath . $this->uniqueFilename .'-'. $resizeSuffix .'.'. $this->fileExtension;
        $resizedRenderStoragePath = $this->renderStoragePath . $this->uniqueFilename .'-'. $resizeSuffix .'.'. $this->fileExtension;

        ## Resize.
        IntImage::make($this->path)->fit($width, $height, function ($c) {
        // Image::make($this->path)->fit(140, 140, function ($c) {
            $c->upsize();
        })->save();

        ## Move to the permanent storage location (local in use here).
        if ( Storage::disk('local')->put( $resizedFinalStoragePath, $handler = fopen($this->path, 'r+')) ) {  
            ## Add document details to 'documents' table.
            $this->saveDocumentInfo( $request, $resizeSuffix );
        }
    }

    /**
     * Save image url links to the IMAGES Table.
     *
     * Saving to storage provider eg S3, dropbox is done inside $uploadModelImage($model, $filename)
     */
    public function saveDocumentInfo( Request $request, $resizeSuffix='' ) 
    {
        $uniqueId     = $this->uniqueFilename .'-'. $resizeSuffix .'.'. $this->fileExtension;

        $document     = New Document;

        $document->user_id           = $this->model->user_id;//auth()->id();
        $document->name              = File::basename($this->path);
        $document->unique_id         = $uniqueId; // getRouteKeyName()
        $document->description       = $request->caption;//(get_class($model) == 'App\Message') ? $model->body : $request->caption;
        $document->url               = $this->renderStoragePath . $uniqueId;
        $document->documentable_id   = $this->model->id;
        $document->documentable_type = get_class($this->model);
        $document->mime              = strtolower(File::extension($this->path));
        $document->size              = File::size($this->path);
        if (get_class($this->model)       == 'App\Application') {
            $document->issued_date   = $request->issued_date;
            $document->expiry_date   = $request->expiry_date;
        }

        $document->save();
        // dd($document);

        return;
    }
}
