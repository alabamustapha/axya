<?php

namespace App\Nova\Metrics;

use App\User;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class UsersGenderPartition extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, User::class, 'gender');
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    public function title()
    {
        return 'Users Gender Stat';
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'users-gender-partition';
    }
}
