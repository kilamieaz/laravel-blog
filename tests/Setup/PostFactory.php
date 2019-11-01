<?php

namespace Tests\Setup;

use App\Comment;
use App\Post;
use App\User;

class PostFactory
{
    protected $commentCount = 0;
    protected $user;

    public function ownedBy($user)
    {
        $this->user = $user;
        //we want use api
        return $this;
    }

    public function withComment($count)
    {
        $this->commentCount = $count;
        //we want use api
        return $this;
    }

    public function create()
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id ?? factory(User::class)
        ]);
        $this->exeComment('create', $post);
        return $post;
    }

    public function raw()
    {
        $post = factory(Post::class)->raw([
            'user_id' => $this->user->id ?? factory(User::class)
        ]);
        $this->exeComment('raw', $post);
        return $post;
    }

    public function exeComment($key, $post)
    {
        factory(Comment::class, $this->commentCount)->$key([
            'user_id' => $post->user->id,
            'post_id' => $post->id
        ]);
    }
}
