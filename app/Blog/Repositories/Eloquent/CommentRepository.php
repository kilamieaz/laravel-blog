<?php

namespace App\Blog\Repositories\Eloquent;

use App\Blog\Repositories\Contract\RepositoryInterface;
use App\Blog\Traits\RepositoryTrait;
use App\Comment;

class CommentRepository implements RepositoryInterface
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Comment();
    }
}
