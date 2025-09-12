<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class shop extends Model
{
    protected $fillable = ['code', 'name', 'owner', 'latitude','longitude','address'];

    function products(): BelongsToMany {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
