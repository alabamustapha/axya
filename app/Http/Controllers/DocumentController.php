<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\DocumentRequest;
use File;
use Response;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Files Uploaded by Auth::user
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $this->authorize('create', Document::class);
        
        $document = new Document;
        $document->user_id       = $request->user_id;
        $document->name          = $request->name;
        $document->description   = $request->description;


        $document->documentable_id = $request->_id;//documentable
        $document->documentable_type = $request->_type;//documentable
        $document->issued_date   = $request->issued_date;
        $document->expiry_date   = $request->expiry_date;

        $document->url           = $request->url;
        $document->mime          = $request->mime;
        $document->size          = $request->size;
        $document->save();




        $directory = 'appl-'. auth()->user()->slug;

        Storage::makeDirectory($directory);

        if($request->url){
            $extension = $request->url->getClientOriginalExtension();

            $document->url  = $request->url;
            $document->mime = $extension;
            $document->size = $request->url->getClientSize();
            // $document->save();

            $name      = '-'. auth()->user()->slug .'.'. $extension;

            $path      = $request->file('url')->storeAs( $directory, $name );
            
            $document->save();
        }

        flash($document->user->name . ', your document was submitted successfully')->success();

        return redirect()->route('users.show', $document->user);
    }

    /**
     * Display the specified resource.
     *
     * @link https://stackoverflow.com/questions/46898095/display-pdf-file-from-local-disk-in-laravel-5
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Document $document)
    {
        // // For Application related docs, get hint from ApplicationController@showFile
        // // $certType      = $request->type; // Med_col, Malpraxis etc

        // // $file          = $application->{$certType};
        // // $userDirectory = 'appl-'. $application->user->slug;
        // // $filePath      = storage_path('app/'. $userDirectory .'/' . $file);

        // $filePath      = storage_path('app/'. $userDirectory .'/' . $file);
        // // $filePath      = storage_path($document->url);
        // // $filePath      = File::realPath($document->url);
        // dd($filePath);

        // // File not found?
        // if(! File::exists($filePath)) { 
        //     dd('File not found');//abort(404); 
        // }

        // $content    = File::get($filePath);
        // $type       = File::mimeType($filePath);
        // $fileName   = File::name($filePath);

        // return response()->file($filePath, [
        //   'Content-Type'        => $type,
        //   'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        // ]);

        $filePath   = storage_path() .'/app'. $document->url;
        $content    = File::get($filePath);
        $type       = File::mimeType($filePath);
        $fileName   = File::name($filePath);
        // dd($type, $fileName);

        return response()->file($filePath, [
          'Content-Type'        => $type,
          'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        ]);


        // $filename = storage_path() .'/app'. $document->url;
        // // dd($filename);
        // $headers = array(
        //     'Content-type'          => 'application/pdf',
        //     'Content-Disposition'   => 'inline; filename="' . $filename . '"'
        // );
        // return Response::make( file_get_contents($filename), 200, $headers);

    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        // Update to caption/decription
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);
        
        if ($document->delete()){
            flash($document->name . ' deleted successfully')->info();
        }

        return redirect()->route('doctors.show', $document->doctor);


        $this->authorize('delete', $document);
        
        if ($document->delete())
        {
            // Delete file/file directory
            // $directory = $document->url;
            // Storage::deleteDirectory($directory);
        }

        flash('Document deleted successfully')->info();

        return redirect()->route('documents.index');
    }
}
