<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location;

class Post extends Model
{
    public function locations()
{
    return $this->belongsToMany(
        Location::class,
        'post_locations'
    );
}
}
