<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
      'name', 'slug', 'price', 'description', 'discount',
    ];
}
