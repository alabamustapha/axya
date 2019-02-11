<?php

namespace App\Traits;

use App\Doctor;
use Illuminate\Http\Request;

/** 
 * This was seperated out to prevent throwing views about within the model.
 * and this serves as a repo for small and basic reuseable views within a doctors model.
 *
 * @param  \App\Doctor  $doctor
 * @param  Illuminate\Http\Request $request
 * @return text/html
 */
trait DoctorViewsTrait
{
    public function availabilityStatus(Doctor $doctor)
    {
        if ($doctor->is_active) {
            echo '<span class="bg-success border border-success rounded" style="width: 12px;height: 12px;position: relative;left:-20px;top:20px;" title="Available"></span>';
        }
        elseif ($doctor->is_suspended) {
            echo '<span class="bg-danger border border-danger rounded" style="width: 12px;height: 12px;position: relative;left:-20px;top:20px;" title="***"></span>';
        }
        else {
            echo '<span class="bg-warning border border-warning rounded" style="width: 12px;height: 12px;position: relative;left:-20px;top:20px;" title="Unavailable"></span>';
        }
    }
}