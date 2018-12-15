<?php

namespace App\Nova\Metrics\Doctors;

use App\Doctor;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;

class DoctorsTrend extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByDays($request, Doctor::class)
                    ->showLatestValue()
                    ;
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            90 => '90 Days',
            60 => '60 Days',
            30 => '30 Days',
            14 => '14 Days',
            7 => '7 Days',
            // 1 => '1 Day',
        ];
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
        return 'doctors-trend';
    }
}
