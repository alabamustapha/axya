<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'      => $this->name,
            'slug'      => $this->slug,
            'email'     => $this->email,
            'address'   => $this->address,
            'phone'     => $this->phone,
            'gender'    => $this->gender,
            'avatar'    => $this->avatar,
            'blocked'   => (bool) $this->blocked,
            'dob'       => $this->dob(),
            'age'       => $this->age,
            'weight'    => $this->weight,
            'height'    => $this->height,
            'allergies' => $this->allergies,
            'chronics'  => $this->chronics,
            'last_four' => $this->last_four,
            'is_doctor' => (bool) $this->is_doctor,
            'is_verified'       => $this->isVerified(),
            'is_staff'          => $this->isStaff(),
            'is_admin'          => $this->isAdmin(),
            'is_super_admin'    => $this->isSuperAdmin(),
            'type'              => $this->type(),
            'active_status'     => $this->status(),
            'professional_type' => $this->professionalType(),
            // 'doctors'   => (array) $this->inPastAttendantDoctors(),
            // 'children'  => (array) $this->inPastAttendantDoctors(),
            'href' => [
                'self' => route('users_api.show', $this),
                // 'doctors' => route('doctors-api.show', $this)
            ]
        ];
    }

    public function with($request)
    {
        return [
            'version' => '1.0.0',
        ];
    }
}
