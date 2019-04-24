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
          ->where(function ($query) use ($q,$tag_spec, $actual_spec){
              $query->where('slug', 'like', "%$q%")
                  ->orwhereIn('specialty_id', $tag_spec)
                  ->orWhereIn('specialty_id', $actual_spec)
            ;
          })->paginate(3);


        // $collection = collect();
        // $collection = $collection->merge($tags);
        // $collection = $collection->merge($specialties);
        // $collection/$doctors = $collection->merge($doctors);
      
        return response()->json($doctors);
      }
    }

    public function doctors(Request $request)
    {
      if (request()->q){
        $q = request()->q;

        // Get Related Specialties.
        $specialties = Specialty::where('name', 'like', "%$q%")->get();
        // Get doctors based on specialties.
        $doc_specialty = array_unique($specialties->pluck('id')->toArray());
        
        $searchType = isset($request->cityId) 
                      ? 'city' : (isset($request->regionId) 
                               ? 'region' : 'all')
                      ;

        switch ($searchType) {
          case 'city':
              $results = Doctor::with('user')
                   ->where('region_id', $request->regionId)
                   ->where('city_id', $request->cityId)
                   ->where('slug', 'like', "%$q%")
                   ->orderBy('slug')
                   ->orderBy('updated_at', 'desc')
                   ->orderBy('available', 'desc')
                   ->paginate(6);
            break;

          case 'region':
              $results = Doctor::with('user')
                   ->where('region_id', $request->regionId)
                   ->where('slug', 'like', "%$q%")
                   ->orderBy('slug')
                   ->orderBy('updated_at', 'desc')
                   ->orderBy('available', 'desc')
                   ->paginate(6);
            break;
          
          case 'all':
              $results = Doctor::with('user')
                   ->where('slug', 'like', "%$q%")
                   ->orWhere('location', 'like', "%$q%")
                   ->orWhere('about', 'like', "%$q%")
                   ->orWhereIn('specialty_id', $doc_specialty)
                   ->orderBy('updated_at', 'desc')
                   ->orderBy('available', 'desc')
                   ->paginate(6);
            break;
        }

        return response()->json($results);
      }
    }

    public function tags()
    {
      if (request()->q){
        $q = request()->q;

        $results = Tag::with('specialty')->where('name', 'like', "%$q%")
                     ->orWhere('description', 'like', "%$q%")
                     ->paginate(15);

        return response()->json($results);
      }
    }

    public function specialties()
    {
      if (request()->q){
        $q = request()->q;

        $results = Specialty::where('name', 'like', "%$q%")
                     // ->orWhere('description', 'like', "%$q%")
                     ->paginate(15);

        return response()->json($results);
      }
    }

    public function users()
    {
      if (request()->q){
        $q = request()->q;

        $results = User::where('name', 'like', "%$q%")
                     ->orWhere('email', 'like', "%$q%")
                     ->orWhere('phone', 'like', "%$q%")
                     ->paginate(6);//get();

        return response()->json($results);
      }
    }

    public function loadRegions($countryId)
    {
        $countryId = $countryId ?: \App\Region::where('name', 'Romania')->first()->country_id;

        $regions = \App\Region::where('country_id', $countryId)
                     ->get()
                     ;

        return response()->json($regions);
    }

    public function loadCities($regionId)
    {
        $regionId = $regionId ?: \App\City::where('name', 'Bucuresti')->first()->region_id;

        $cities = \App\City::where('region_id', $regionId)
                     ->get()
                     ;

        return response()->json($cities);
    }
}
