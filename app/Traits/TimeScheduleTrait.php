<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;

trait TimeScheduleTrait
{
    // Convert appointment time to 24 hours format.
    public function formatHourTo2400(Request $request)
    {
        // Convert all time requests to h:i A format at backend. 
        // Makes parsing for create and Update work the same way.
        $rq_to   = Carbon::parse($request->to)->format('h:i A');
        $rq_from = Carbon::parse($request->from)->format('h:i A');
        $rq_day  = Carbon::parse($request->day)->format('Y-m-d');

        $__to = explode(' ', $rq_to); reset($__to);
        $to = current($__to);
        $__from = explode(' ', $rq_from); reset($__from);
        $from = current($__from);

        if (end($__to) == 'PM'){
            // Segment parts into hour and min eg: 11:30 PM
            $__to = explode(':', $to); reset($__to);
                $hour_segment = intval(current($__to));// 11
                $mins_segment = end($__to);            // 30
            // Add to 12:00 to return the 24hr format
            $formatedHour = ($hour_segment == 12) 
                ? $hour_segment // Correction for 12PM hours
                : 12 + $hour_segment
                ;
            
            // Reformated To
            $to = $formatedHour .':'. $mins_segment;
        }

        if (end($__from) == 'PM'){
            $__from = explode(':', $from); reset($__from);
                $hour_segment = intval(current($__from));// 11
                $mins_segment = end($__from);            // 30

            $formatedHour = ($hour_segment == 12) 
                ? $hour_segment // Correction for 12PM hours
                : 12 + $hour_segment
                ;

            $from = $formatedHour .':'. $mins_segment;
        }

        // Convert time to Schedule Day + Time. (Y-m-d h:i A)
        $from = $rq_day .' '. $from;
        $to   = $rq_day .' '. $to; 
        // dd(
        //     $request->from,$request->to, $rq_from,$rq_to,
        //     $__from,$__to, $from,$to, $rq_day
        // );

        $request->merge([
            'user_id' => auth()->id(), // booted()
            'from' => $from,
            'to'   => $to,
        ]);

        return;
    }
}