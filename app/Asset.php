<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function region()
    {
    	return $this->belongsTo(Region::class);
    }
}
