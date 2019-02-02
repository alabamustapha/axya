<?php

namespace App\Nova\Metrics\Doctors;

use App\Doctor;
use App\Specialty;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class DoctorsPartition extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Doctor::class, 'specialty_id')
            ->label(function ($value) {
                $label = Specialty::find($value)->name;
                
                return ucfirst($label);
            });
    }

    public function title()
    {
       return 'Doctors By Specialty';
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(3);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'doctors-partition';
    }
}
