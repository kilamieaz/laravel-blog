<?php

namespace App\Blog\Reporting;

use App\Blog\Repositories\Contract\FactoryInterface;

class FactoryReporter
{
    public function build(FactoryInterface $factory, $build)
    {
        return $factory->$build();
    }
}
