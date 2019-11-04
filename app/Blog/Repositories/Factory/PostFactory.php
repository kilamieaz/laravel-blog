<?php

namespace App\Blog\Repositories\Factory;

use App\Post;
use App\User;
use App\Comment;
use App\Blog\Traits\BuildFactory;
use App\Blog\Repositories\Contract\FactoryInterface;

class PostFactory implements FactoryInterface
{
    use BuildFactory;

    protected $model;
    protected $user;
    protected $commentCount;

    public function __construct($user = null, $commentCount = 0)
    {
        $this->model = Post::class;
        $this->user = $user;
        $this->commentCount = $commentCount;
    }

    public function create()
    {
        $post = $this->build($this->model);

        $this->addComment($post);
        $this->addOwner($post);
        return $post->refresh();
    }

    public function raw()
    {
        $post = $this->build($this->model);

        $this->addComment($post);
        $this->addOwner($post);
        return $post->refresh()->toArray();
    }

    public function addComment($post)
    {
        factory(Comment::class, $this->commentCount)->create([
            'user_id' => $this->user->id ?? factory(User::class),
            'post_id' => $post->id
        ]);
    }

    public function addOwner($post)
    {
        if ($this->user) {
            $post->update(['user_id' => $this->user->id]);
        }
    }

    public function withComment($count)
    {
        $this->commentCount = $count;
        //we want use api
        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;
        //we want use api
        return $this;
    }
}
