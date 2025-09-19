<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['code', 'name', 'price', 'description','category_id'];

    function shops(): BelongsToMany {
        return $this->belongsToMany(shop::class)->withTimestamps();
    }

    function category(): BelongsTo {
        return $this->belongsTo(category::class);
    }
}
