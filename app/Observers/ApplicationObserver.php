<?php

namespace App\Observers;

use App\Application;
use Illuminate\Support\Facades\Storage;

class ApplicationObserver
{
    /**
     * Handle the application "creating" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function creating(Application $application)
    {
        // $directory = 'appl-'. auth()->user()->slug;

        // if ($request->medical_college){
        //     Storage::makeDirectory($directory);
        // }

        // if($request->medical_college){
        //     $extension = $request->medical_college->getClientOriginalExtension();
        //     $name      = 'appl-mc-'. auth()->user()->slug .'.'. $extension;
        //     $path      = $request->file('medical_college')->storeAs( $directory, $name );
        //     $application->medical_college = $name;
        // }

        // if($request->specialist_diploma){
        //     $extension = $request->specialist_diploma->getClientOriginalExtension();
        //     $name      = 'appl-sd-'. auth()->user()->slug .'.'. $extension;
        //     $path      = $request->file('specialist_diploma')->storeAs( $directory, $name );
        //     $application->specialist_diploma = $name;
        // }

        // if($request->competences){
        //     $extension = $request->competences->getClientOriginalExtension();
        //     $name      = 'appl-cp-'. auth()->user()->slug .'.'. $extension;
        //     $path      = $request->file('competences')->storeAs( $directory, $name );
        //     $application->competences = $name;
        // }

        // if($request->malpraxis){
        //     $extension = $request->malpraxis->getClientOriginalExtension();
        //     $name      = 'appl-mp-'. auth()->user()->slug .'.'. $extension;
        //     $path      = $request->file('malpraxis')->storeAs( $directory, $name );
        //     $application->malpraxis = $name;
        // }

        // $application->save();
    }
    /**
     * Handle the application "created" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function created(Application $application)
    {
        //
    }

    /**
     * Handle the application "updated" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function updated(Application $application)
    {
        //
    }

    /**
     * Handle the application "deleted" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function deleted(Application $application)
    {
        //
    }

    /**
     * Handle the application "restored" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function restored(Application $application)
    {
        //
    }

    /**
     * Handle the application "force deleted" event.
     *
     * @param  \App\Application  $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }
}
