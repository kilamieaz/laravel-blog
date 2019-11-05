<?php

namespace App\Blog\Repositories\Factory;

use App\Category;
use App\Blog\Traits\BuildFactory;
use App\Blog\Repositories\Contract\FactoryInterface;

class CategoryFactory implements FactoryInterface
{
    use BuildFactory;

    protected $data;
    protected $user;

    public function __construct($user = null)
    {
        $this->data = $this->build(Category::class);
        $this->user = $user;
    }

    public function create()
    {
        $category = $this->data;

        $this->addOwner($category);
        return $category->refresh();
    }

    public function raw()
    {
        $category = $this->data;

        $this->addOwner($category);
        return $category->refresh()->toArray();
    }

    public function addOwner($post)
    {
        if ($this->user) {
            $post->update(['user_id' => $this->user->id]);
        }
    }
}
