<?php

namespace App\Blog\Repositories\Factory;

use App\Category;
use App\Blog\Traits\BuildFactory;
use App\Blog\Repositories\Contract\FactoryInterface;
use App\Comment;

class CommentFactory implements FactoryInterface
{
    use BuildFactory;

    protected $data;
    protected $user;

    public function __construct($user = null)
    {
        $this->data = $this->build(Comment::class);
        $this->user = $user;
    }

    public function create()
    {
        $comment = $this->data;

        $this->addOwner($comment);
        return $comment->refresh();
    }

    public function raw()
    {
        $comment = $this->data;

        $this->addOwner($comment);
        return $comment->refresh()->toArray();
    }

    public function addOwner($post)
    {
        if ($this->user) {
            $post->update(['user_id' => $this->user->id]);
        }
    }
}
