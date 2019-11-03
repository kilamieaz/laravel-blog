<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use UsesUuid;

    protected $fillable = ['user_id', 'name', 'slug', 'description'];
}
