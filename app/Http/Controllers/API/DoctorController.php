<?php

namespace App\Http\Controllers\Api;

use App\Doctor;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\DoctorsUpdateRequest;
use App\Http\Resources\Doctor\DoctorResource;
use App\Traits\CustomAuthorizationsTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends Controller
{
    use CustomAuthorizationsTrait;

    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DoctorResource::collection(Doctor::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request)
    {
        // 1.
        $doctor = Doctor::create([
            'id'         => $request['id'],
            'user_id'    => $request['user_id'],
            'slug'       => $request['slug'],
            // 'specialty_id' => $request['specialty_id'],
        ]);
        $doctor->specialties()->sync($request->specialties);
        $doctor->save();
        // $doctor = Doctor::create($request->all());

        return response()->json(new DoctorResource($doctor), Response::HTTP_CREATED);//201
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Doctor  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $doctor = Doctor::whereSlug($slug)->firstOrFail();

        return new DoctorResource($doctor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorsUpdateRequest $request, $slug)
    {
        $doctor = Doctor::whereSlug($slug)->firstOrFail();

        $this->canEditDoctor($doctor);

        $doctor->update($request->all());

        return response()->json(new DoctorResource($doctor),  Response::HTTP_OK);//200
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $doctor = Doctor::whereSlug($slug)->firstOrFail();
        
        $this->canRemoveDoctor($doctor);

        // If not cascaded, 
        // $doctor->associated_model->each()->delete();
        $doctor->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);//204
    }
}
