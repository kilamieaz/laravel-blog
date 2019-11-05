<?php

namespace Tests;

use Facades\App\Blog\Reporting\FactoryReporter;
use App\Blog\Repositories\Contract\FactoryInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        $user = $user ?: factory('App\User')->create();
        $this->actingAs($user);
        return $user;
    }

    public function createfactory(FactoryInterface $factory)
    {
        return FactoryReporter::build($factory, 'create');
    }

    public function rawfactory(FactoryInterface $factory)
    {
        return FactoryReporter::build($factory, 'raw');
    }
}
