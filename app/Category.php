<?php

namespace App;

use App\Blog\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use UsesUuid, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'slug', 'description'];

    public function path()
    {
        return url("/categories/{$this->id}/" . slug($this->name));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_posts');
    }
}
