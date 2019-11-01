<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use UsesUuid;
    protected $fillable = ['user_id', 'slug', 'title', 'body', 'published', 'image'];
    // protected $guarded = [];

    public function path()
    {
        return url("/posts/{$this->id}/" . slug($this->title));
    }
}
