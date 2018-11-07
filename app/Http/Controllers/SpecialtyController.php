<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialtyRequest;
use App\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialties = Specialty::orderBy('name')->paginate(25);

        return view('specialties.index', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialtyRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        
        $specialty = Specialty::create($request->all());

        if ($specialty){
            flash($specialty->name . ' created successfully')->success();
        }

        return redirect()->route('specialties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function show(Specialty $specialty)
    {
        return view('specialties.show', compact('specialty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function update(SpecialtyRequest $request, Specialty $specialty)
    {
        if ($specialty->update($request->all())){
            flash($specialty->name . ' updated successfully')->success();
        }

        return redirect()->route('specialties.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialty $specialty)
    {
        if ($specialty->delete()){
            flash($specialty->name . ' deleted successfully')->info();
        }

        return redirect()->route('specialties.index');
    }
}
