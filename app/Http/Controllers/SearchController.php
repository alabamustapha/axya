<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Http\Controllers\Controller;
use App\Specialty;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function index()
    {
      if (request()->q){
        $q = request()->q;

        // Get Related Tags.
        $tags = Tag::where('name', 'like', "%$q%")
                   // ->orWhere('description', 'like', "%$q%")
                   ->get();

        // Get Related Specialties.
        $specialties = Specialty::where('name', 'like', "%$q%")
                   // ->orWhere('description', 'like', "%$q%")
                   ->get();

        // Get doctors specialty based on related tags.
        $tag_spec    = array_unique($tags->pluck('specialty_id')->toArray());

        // Get doctors based on specialties.
        $actual_spec = array_unique($specialties->pluck('id')->toArray());

        // **with('user')** helps to link to relational *users* table for Vue rendering.
        $doctors =  Doctor::with('user')
          ->where(function ($query) use ($q,$tag_spec,$actual_spec){
              $query->where('slug', 'like', "%$q%")
                  ->orwhereIn('specialty_id', $tag_spec)
                  ->orWhereIn('specialty_id', $actual_spec)
            ;
          })->paginate(3);
          // dd($tags,$doctors->count());


        // $collection = collect();
        // $collection = $collection->merge($tags);
        // $collection = $collection->merge($specialties);
        // $collection = $collection->merge($doctors);

        // // https://medium.com/@AceKYD/custom-pagination-view-in-laravel-5-with-arrays-769cd21bea74
        // $results = array();

        // $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // $per_page = 200;

        // $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
        // $results = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);
        // // $results->setPath($request->url());
        // // dd($tags->count(),$specialties->count(),$doctors->count(),$results->count());
      
        return $doctors;
      }
    }
}
