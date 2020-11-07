<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Footprint extends Model
{
    //
    protected $fillable = ['activity', 'activityType', 'country', 'fuelType', 'mode', 'response'];
}