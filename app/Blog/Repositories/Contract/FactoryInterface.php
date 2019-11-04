<?php

namespace App\Blog\Repositories\Contract;

interface FactoryInterface
{
    public function create();

    public function raw();
}
