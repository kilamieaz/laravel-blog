<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use UsesUuid;

    protected $guarded = [];

    public function path()
    {
        return url("/posts/{$this->id}-" . Str::slug($this->title));
    }
}
