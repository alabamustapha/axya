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

class DocumentUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;
    public $modelClassName;

    public $filename;
    public $path;
    public $fileStoragePath;
    public $fileRenderPath;
    public $fileExtension;
    public $uniqueFilename;
    public $resizes;
    public $dynamicTempLink;
    public $dynamicSaveLink;
    public $dynamicServeLink;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $model, $filename, $modelClassName )
    {
        $this->model            = $model;
        $this->modelClassName   = $modelClassName;

        $this->dynamicTempLink  = 'filesystems.behealthy.temporary.' . $this->modelClassName;
        $this->dynamicSaveLink  = 'filesystems.behealthy.save.' . $this->modelClassName;
        $this->dynamicServeLink = 'filesystems.behealthy.serve.' . $this->modelClassName;

        $this->filename         = $filename;
        $this->path             = config( $this->dynamicTempLink ) . $this->filename;
        $this->fileExtension    = strtolower(File::extension($this->path));
        $this->uniqueFilename   = str_replace('.', '', uniqid('', true) . time());

        $this->fileStoragePath  = config( $this->dynamicSaveLink );
        $this->fileRenderPath   = config( $this->dynamicServeLink );
        
        $this->resizes =  [
            'md' => [400, 400],
            'tb' => [150, 150],
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        /** 
         ## Move to the permanent storage location.
         * 
         * if ( Storage::disk('s3Videos')->put(...)) {};
         * A sub for the 3rd-party storage service used instead.
         */
        $resizedFileStoragePath  = $this->fileStoragePath . $this->uniqueFilename .'.'. $this->fileExtension;

        if ( Storage::disk('local')->put($resizedFileStoragePath, $handler = fopen($this->path, 'r+')) ) {  
            ## Add document details to 'documents' table.
            $this->saveDocumentInfo( $request );

            $isImage = in_array(strtolower(File::extension($this->path)), ['jpg','jpeg', 'png']);

            if ( !$isImage || ($isImage && !isset($request->resize)) ) {
                
                // delete from temporary local storage.
                fclose($handler);
                File::delete($this->path);
            }
            elseif ($isImage && isset($request->resize)) {               
                $i = 0;
                foreach ($this->resizes as $key => $val) {
                    $resize 
                        = list($name, $width, $height) 
                            = array($key, $val['0'], $val[1]);

                    $this->resizeImage( $request, $resize );
                    $i++;

                    // If last resize, 
                    if ($i == sizeof($this->resizes)) {
                        fclose($handler);
                        File::delete($this->path);
                    }
                }
            }
        }
    }

    /**
     * For Images Only.
     * Resizes an image that has a RESIZE request.
     *
     * @return null
     */
    public function resizeImage( Request $request, $resize )
    {
        $resizeSuffix = '-'. $resize[0];
        $width        = $resize[1];
        $height       = $resize[2];

        $resizedPath            = $this->path;
        $resizedFileStoragePath = $this->fileStoragePath . $this->uniqueFilename . $resizeSuffix .'.'. $this->fileExtension;

        ## Resize.
        if ($this->modelClassName == 'users') {
            IntImage::make($this->path)
                ->fit(   $width, $height, function ($constraint) { $constraint->upsize(); })     // SquareCut@centerBottom.
                // ->encode('png')
                ->save();
        } else {
            IntImage::make($this->path)
                ->resize($width, $height, function ($constraint) { $constraint->aspectRatio(); })// 400x301 FullRzCut.
                // ->encode('png')
                ->save();
        }

        ## Move to the permanent storage location (local in use here).
        if ( Storage::disk('local')->put( $resizedFileStoragePath, $handler = fopen($this->path, 'r+')) ) {  
            ## Add document details to 'documents' table.
            $this->saveDocumentInfo( $request, $resizeSuffix );
        }
    }

    /**
     * Save document details to 'documents' table.
     *
     * @return null
     */
    public function saveDocumentInfo( Request $request, $resizeSuffix='' ) 
    {
        $uniqueId = $this->uniqueFilename . $resizeSuffix .'.'. $this->fileExtension;

        $document = New Document;

        $document->user_id           = auth()->id();//$this->model->user_id;//
        $document->name              = File::basename($this->path);
        $document->unique_id         = $uniqueId; 
        $document->description       = $request->caption;
        $document->url               = $this->fileRenderPath . $uniqueId;
        $document->documentable_id   = $this->model->id;
        $document->documentable_type = get_class($this->model);
        $document->mime              = strtolower(File::extension($this->path));
        $document->mime_type         = File::mimeType($this->path); // For file rendering.
        $document->size              = File::size($this->path);
        if (get_class($this->model)       == 'App\Application') {
            $document->issued_date   = $request->issued_date;
            $document->expiry_date   = $request->expiry_date;
        }

        $document->save();

        $this->modelClassName == 'users' ? auth()->user()->update(['avatar' => $document->url]):false;

        return;
    }
}
