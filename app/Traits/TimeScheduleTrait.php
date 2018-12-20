<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait TimeScheduleTrait
{
    public function formatHourTo2400(Request $request)
    {
        $__to = explode(' ', $request->to); reset($__to);
        $to = current($__to);
        $__from = explode(' ', $request->from); reset($__from);
        $from = current($__from);

        if (end($__to) == 'PM'){
            // Segment parts into hour and min eg: 11:30 PM
            $__to = explode(':', $to); reset($__to);
                $hour_segment = intval(current($__to));// 11
                $mins_segment = end($__to);            // 30
            // Add to 12:00 to return the 24hr format
            $formatedHour = 12 + $hour_segment;
            
            // Reformated To
            $to = $formatedHour .':'. $mins_segment;
        }

        if (end($__from) == 'PM'){
            $__from = explode(':', $from); reset($__from);
                $hour_segment = intval(current($__from));// 11
                $mins_segment = end($__from);            // 30

            $formatedHour = 12 + $hour_segment;

            $from = $formatedHour .':'. $mins_segment;
        }

        $request->merge([
            // 'user_id' => auth()->id(), // booted()
            'to' => $to,
            'from' => $from,
        ]);

        return;
    }
}