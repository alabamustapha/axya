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

        if ( auth()->id() !== $image->user_id || ! auth()->user()->isAdmin()){
            request()->session()->flash('error', 'You can only delete your own uploaded images.');
            return back();
        }

        // 1.
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

        $image->delete(); // From images table

        request()->session()->flash('success', 'Image was successfully removed.');
        return redirect()->back();
    }   
}

