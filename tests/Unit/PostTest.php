<?php

namespace Tests\Unit;

use Facades\Tests\Setup\PostFactory;
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
        $this->assertEquals(1, $post->user->count());
        $this->assertInstanceOf('App\User', $post->user);
    }

    /** @test */
    public function it_has_many_comments()
    {
        $post = PostFactory::ownedBy($this->signIn())->withComment(2)->create();
        // Count that a post comments collection exists.
        $this->assertEquals(2, $post->comments->count());
        // Comments are related to posts and is a collection instance.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $post->comments);
    }
}
