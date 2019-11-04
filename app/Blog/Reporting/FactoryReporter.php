<?php

namespace App\Blog\Reporting;

use App\Blog\Repositories\Contract\FactoryInterface;

class FactoryReporter
{
    public function create(FactoryInterface $factory)
    {
        return $factory->create();
    }

    public function raw(FactoryInterface $factory)
    {
        return $factory->raw();
    }
}
