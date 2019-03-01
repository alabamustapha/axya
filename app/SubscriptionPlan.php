<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use Sluggable;

    protected $fillable = [
      'name', 'slug', 'price', 'description', 'discount',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getlinkAttribute()
    {
        return route('subscription_plans.show', $this);
    }
}
