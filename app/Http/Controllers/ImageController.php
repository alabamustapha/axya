<?php

namespace App\Http\Controllers;

use Storage;
use App\Image;
use Illuminate\Http\Request;
use App\Jobs\RemoveReportImage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $images = auth()->user()->images()->paginate(10);

      return view('images.index', compact('images'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $this->authorize('delete', $image);

        // 1. Remove all sizes from disk
        if ($image->url) {
            $image_frags = explode('/', $image->url);
            $file_name = end($image_frags);

            Storage::disk('s3images')->delete('reports/' . $file_name);
        }
        if ($image->medium_url) {
            $image_frags = explode('/', $image->medium_url);
            $file_name = end($image_frags);

            Storage::disk('s3images')->delete('reports/' . $file_name);
        }
        if ($image->thumbnail_url) {
            $image_frags = explode('/', $image->thumbnail_url);
            $file_name = end($image_frags);

            Storage::disk('s3images')->delete('reports/' . $file_name);
        }

        // 2. Remove reference link from images table
        $image->delete();

        request()->session()->flash('success', 'Image was successfully removed.');
        return redirect()->back();
    }   
}

