<?php

namespace App;

use App\Blog\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use UsesUuid, SoftDeletes;
    protected $fillable = ['user_id', 'slug', 'title', 'body', 'published', 'image'];
    // protected $guarded = [];

    public function path()
    {
        return url("/posts/{$this->id}/" . slug($this->title));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts');
    }
}
