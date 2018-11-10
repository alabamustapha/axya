<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Requests\ApplicationRequest;
use App\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only('index');
        $this->middleware('application')->only('store');
        $this->middleware('verified');//->only('store');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::oldest()->paginate(25);

        return view('applications.index', compact('applications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        // $this->authorize('create', Application::class);
        
        $application = new Application;
        $application->user_id           = auth()->id();
        $application->specialty_id      = $request->specialty_id[0];
        $application->first_appointment = $request->first_appointment;
        $application->workplace         = $request->workplace;
        $application->workplace_address = $request->workplace_address;
        $application->workplace_start   = $request->workplace_start;
        $application->medical_college_expiry = $request->medical_college_expiry;

        $directory = 'appl-'. auth()->user()->slug;

        if ($request->medical_college){
            Storage::makeDirectory($directory);
        }

        if($request->medical_college){
            $extension = $request->medical_college->getClientOriginalExtension();
            $name      = 'appl-mc-'. auth()->user()->slug .'.'. $extension;
            $full_directory = $directory .'/'. $name;
            $path      = $request->file('medical_college')->storeAs( $directory, $full_directory );
            $application->medical_college = $name;
        }

        if($request->specialist_diploma){
            $extension = $request->specialist_diploma->getClientOriginalExtension();
            $name      = 'appl-sd-'. auth()->user()->slug .'.'. $extension;
            $full_directory = $directory .'/'. $name;
            $path      = $request->file('specialist_diploma')->storeAs( $directory, $full_directory );
            $application->specialist_diploma = $name;
        }

        if($request->competences){
            $extension = $request->competences->getClientOriginalExtension();
            $name      = 'appl-cp-'. auth()->user()->slug .'.'. $extension;
            $full_directory = $directory .'/'. $name;
            $path      = $request->file('competences')->storeAs( $directory, $full_directory );
            $application->competences = $name;
        }

        if($request->malpraxis){
            $extension = $request->malpraxis->getClientOriginalExtension();
            $name      = 'appl-mp-'. auth()->user()->slug .'.'. $extension;
            $full_directory = $directory .'/'. $name;
            $path      = $request->file('malpraxis')->storeAs( $directory, $full_directory );
            $application->malpraxis = $name;
        }

        # Certificate uploads handled in ApplicationObserver@created
        
        if ($application->save()){

            $application->user->updateRegistrationStatus('received');

        }

        flash($application->user->name . ', your application was submitted successfully')->success();

        return redirect()->route('users.show', $application->user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        $this->authorize('admin', $application);

        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        // Delete Appl
        // Delete folder directory
    }
}
