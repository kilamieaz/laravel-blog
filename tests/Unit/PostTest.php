<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_path()
    {
        $post = factory('App\Post')->create();
        $this->assertEquals(url("/posts/$post->id/$post->slug"), $post->path());
    }

    /** @test */
    public function it_belongs_to_an_user()
    {
        $post = factory('App\Post')->create();
        $this->assertInstanceOf('App\User', $post->user);
    }
}
