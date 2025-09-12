<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category extends Model
{
    protected $fillable = ['code', 'name', 'description'];

    function products() : HasMany {
        return $this->HasMany(Product::class);
    }
}
