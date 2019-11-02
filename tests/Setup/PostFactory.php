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
        $this->exeComment($post);
        return $post;
    }

    public function raw()
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id ?? factory(User::class)
        ]);
        $this->exeComment($post);
        return $post->toArray();
    }

    public function exeComment($post)
    {
        factory(Comment::class, $this->commentCount)->create([
            'user_id' => $this->user->id ?? factory(User::class),
            'post_id' => $post->id
        ]);
    }
}
