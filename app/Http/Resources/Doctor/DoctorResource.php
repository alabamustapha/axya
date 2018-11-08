<?php

namespace App\Http\Resources\Doctor;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'      => $this->user->name,
            'slug'      => $this->slug,
            'email'     => $this->user->email,
            'address'   => $this->address,
            'phone'     => $this->user->phone,
            'gender'    => $this->user->gender,
            'avatar'    => $this->user->avatar,
            // 'specialties' => (array) $this->specialties,
            'blocked'   => (bool) $this->blocked,

            'last_four' => $this->user->last_four,

            // 'patients'   => (array) $this->patients()->get(),
            'href' => [
                'self' => route('doctors_api.show', $this),
            ]
        ];
    }
}
