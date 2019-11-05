<?php

namespace Tests\Unit;

use App\Blog\Repositories\Factory\CategoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $category = $this->createfactory(new CategoryFactory());
        $this->assertEquals(url("/categories/$category->id/$category->slug"), $category->path());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $category = $this->createfactory(new CategoryFactory());
        $this->assertEquals(1, $category->user->count());
        $this->assertInstanceOf('App\User', $category->user);
    }

    /** @test */
    public function it_belongs_to_many_categories()
    {
        $category = $this->createfactory(new CategoryFactory());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->posts);
    }
}
