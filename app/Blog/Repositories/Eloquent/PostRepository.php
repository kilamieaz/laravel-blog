<?php

namespace App\Blog\Repositories\Eloquent;

use App\Blog\Repositories\Contract\RepositoryInterface;
use App\Blog\Traits\RepositoryTrait;
use App\Post;

class PostRepository implements RepositoryInterface
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Post();
    }

    public function latest()
    {
        return $this->model->latest('created_at')->get();
    }
}
