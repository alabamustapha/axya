<?php

namespace App\Repositories;

use App\Appointment;
use Carbon\Carbon;

class AppointmentRepository
{
    protected $correspondense_end;

    public function __construct()
    {
      // $this->correspondence_end = Carbon::parse($this->from)->addDays(setting('correspondence_period'));
    }


    // public function hasActiveCorrespondence()
    // {
    //     // Active + Pending Appointments.
    //     return Appointment::whereIn('status', ['1','5'])
    //                  ->where('from', '>', Carbon::now()) // We need pendings...
    //                  // ->where('from', '<', $this->correspondence_end)
    //                  ->paginate(10)
    //                  ;
    // }
  
}