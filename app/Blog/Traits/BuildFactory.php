<?php

namespace App\Blog\Traits;

trait BuildFactory
{
    public function build($model)
    {
        return factory("$model")->create();
    }
}
