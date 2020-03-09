<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Video extends Model
{
   protected $fillable = ['kind'];
}
