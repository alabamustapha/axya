<?php

namespace App\Nova\Metrics\Applications;

use App\Specialty;
use App\Application;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class ApplicationsBySpecialty extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Application::class, 'specialty_id')
            ->label(function ($value) {
                $label = Specialty::find($value)->name;
                
                return ucfirst($label);
            })
            ;
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
        return 'applications-by-specialty';
    }
}
