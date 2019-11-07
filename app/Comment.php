<?php

namespace App;

use App\Blog\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use UsesUuid, SoftDeletes;

    protected $fillable = ['post_id', 'user_id', 'ip', 'guest_name', 'guest_email', 'body', 'approved'];

    public function path()
    {
        return url("/posts/{$this->id}/" . slug($this->title));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
