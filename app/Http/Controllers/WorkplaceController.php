<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkplaceRequest;
use App\Http\Requests\WorkplaceUpdateRequest;
use App\Workplace;
use Illuminate\Http\Request;

class WorkplaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('doctor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkplaceRequest $request)
    {
        $this->authorize('create', Workplace::class);

        auth()->user()->isAdmin() 
            ? $request->merge(['user_id' => $request->doctor_id])
            : $request->merge(['user_id' => auth()->id()])
            ;
        
        $workplace = Workplace::create($request->all());

        if ($workplace){
            flash($workplace->name . ' created successfully')->success();
        }

        return redirect()->route('doctors.show', $workplace->doctor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Workplace  $workplace
     * @return \Illuminate\Http\Response
     */
    public function update(WorkplaceUpdateRequest $request, Workplace $workplace)
    {
        $this->authorize('edit', $workplace);

        if ($workplace->update($request->all())){
            flash($workplace->name . ' updated successfully')->success();
        }

        return redirect()->route('doctors.show', $workplace->doctor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workplace  $workplace
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workplace $workplace)
    {
        $this->authorize('delete', $workplace);
        
        if ($workplace->delete()){
            flash($workplace->name . ' deleted successfully')->info();
        }

        return redirect()->route('doctors.show', $workplace->doctor);
    }
}
