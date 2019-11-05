<?php

namespace Tests\Unit;

use App\Blog\Repositories\Factory\PostFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_path()
    {
        $post = $this->createfactory(new PostFactory());
        $this->assertEquals(url("/posts/$post->id/$post->slug"), $post->path());
    }

    /** @test */
    public function it_belongs_to_an_user()
    {
        $post = $this->createfactory(new PostFactory());
        $this->assertEquals(1, $post->user->count());
        $this->assertInstanceOf('App\User', $post->user);
    }

    /** @test */
    public function it_has_many_comments()
    {
        $post = $this->createfactory(new PostFactory($this->signIn(), 2));
        // Count that a post comments collection exists.
        $this->assertEquals(2, $post->comments->count());
        // Comments are related to posts and is a collection instance.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $post->comments);
    }

    /** @test */
    public function it_belongs_to_many_categories()
    {
        $post = $this->createfactory(new PostFactory());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $post->categories);
    }
}
