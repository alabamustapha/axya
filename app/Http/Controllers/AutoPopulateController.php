<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AutoPopulateController extends Controller
{
    /** 
     * Called from Admin Dashboard
     * A form within: admin/partials/right-sidebar-nav.blade.php
     */
    public function manualPopulate()
    {
        dd('auto pop?');
        // $specialties = [];
        // foreach ($specialties as $specialty) {
        //     \App\Specialty::create([
        //         'name'     => $specialty,
        //         'description' => 'some descriptions here',
        //         'user_id' => 1,
        //         'accepted_at' => random_int(1990, 2019).'-'.random_int(01, 12).'-'.random_int(01, 31).' 00:00:00',
        //     ]);
        // }
        // $users = [];
        for ($i = 3; $i<= 1001; $i++) {
            // dd('auto pop?');
            $user           = \App\User::find($i);
            $specialtyCount = \App\Specialty::all()->count();

            $start_time  = '5:00:00';
            $end_time    = random_int(00, 23).':'.random_int(00, 59).':'.random_int(00, 59);

            $doctor = \App\Doctor::create([

            'id'        => $user->id,
            'user_id'   => $user->id,
            'email'     => $user->email,
            'phone'     => $user->phone,
            'slug'      => $user->slug,
            'about'     => ucfirst(str_random(6)) .' '. strtolower(str_random(10)) .' '. strtolower(str_random(8)) .' and I am fun.',

            // Location
            'home_address'=> $user->address,
            'work_address'=> $user->address,
            

            // Work
            'rate'      => random_int(5, 1000), // $ per session
            'session'   => random_int(30, 120),// In Minutes
            'first_appointment' => Carbon::parse('-' .random_int(30, 1720) . ' day'),
            'available' => random_int(0, 1),// 1:Available, 0:Not Available.
            'subscription_ends_at' => Carbon::parse(random_int(30, 720) . ' day'),

            // Education
            'degree'        => ucfirst(str_random(6, 15)),
            'residency'     => $user->address,
            'specialty_id'  => random_int(1, $specialtyCount),

            'verified_at'   => Carbon::parse('-' .random_int(30, 1020) . ' day'),

            // 'serialized_schedules' => $axiosSchedules,
            ]);
        }
        // $users = User::all();
        // foreach ($users as $user) {
        //     // dd('auto pop?');
        //     $user->update([ 'email'    => $user->slug . '@gmail.com', ]);
        // }

        // $specialties = [
        //     //
        // ];
        // for($i = 2; $i<= sizeof($specialties); $i++) {
        //     User::find($i)->update(['specialty' => $specialty]);
        // }
        // $addresses = [];
        // for($i = 2; $i<= sizeof($addresses); $i++) {
        //     User::find($i)->update(['address' => $addresses[$i]]);
        // }
        // $emails = [
        //     //
        // ];
        // for($i = 2; $i<= sizeof($emails); $i++) {
        //     User::find($i)->update(['email' => $email]);
        // }
        // $phones = [
        //     //
        // ];
        // $phones = [];
        // for($i = 2; $i<= sizeof($phones); $i++) {
        //     User::find($i)->update(['phone' => $phones[$i]]);
        // }
    }
}
