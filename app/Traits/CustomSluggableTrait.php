<?php

namespace App\Traits;

use App\User;
use Illuminate\Http\Request;

/** 
 * Update a user's slug and respective doctor profile slug if available.
 * If same slug is found, check if it has a -integer at the end, 
 * Increment by 1 if found, otherwise append 1.
 *
 * @param  \App\User  $user
 * @param  Illuminate\Http\Request $request
 * @return void
 */
trait CustomSluggableTrait
{
    public function updateSlug(Request $request, User $user)
    {
        if ($request->name !== $user->name) {
            $name_slug = str_slug($request->name);

            $unique_user = 
                // User::where('slug', 'like', '%'.$name_slug.'%')
                User::where('slug', $name_slug)
                    ->orderBy('slug', 'desc')
                    ->first()
                    ;
            
            if ($unique_user) {
                $slug_frags = explode('-', $unique_user->slug);
                $end        = end($slug_frags);
                $unique_id  = is_numeric($end) ? $end + 1 : '1';
            }
            
            // Append a unique integer if same slug is found.
            $slug = $unique_user 
                ? $name_slug .'-'. $unique_id 
                : $name_slug;

            $request->merge(['slug' => $slug]);

            $user->doctor()->count() 
                ? $user->doctor->update(['slug' => $slug]) 
                : false;
            // dd(
            //     $request->name !== $user->name,
            //     $request->name,
            //     $user->name,
            //     $unique_user,
            //     $slug_frags,
            //     $end,
            //     $unique_id,
            //     $slug,
            //     $user->doctor()->count()
            // );
        }

        return;
    }
}