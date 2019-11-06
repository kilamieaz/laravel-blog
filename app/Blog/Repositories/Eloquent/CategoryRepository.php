<?php

namespace App\Blog\Repositories\Eloquent;

use App\Blog\Repositories\Contract\RepositoryInterface;
use App\Blog\Traits\RepositoryTrait;
use App\Category;

class CategoryRepository implements RepositoryInterface
{
    use RepositoryTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Category();
    }
}
