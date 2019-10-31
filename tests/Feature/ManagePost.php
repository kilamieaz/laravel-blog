<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagePost extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_posts()
    {
        $post = factory('App\Post')->create();
        //index
        $this->get('/posts')->assertRedirect('login');
        //create
        $this->get('/posts/create')->assertRedirect('login');
        //store
        $this->post('/posts', $post->toArray())->assertRedirect('login');
        //edit
        $this->get($post->path() . '/edit')->assertRedirect('login');
        //update
        $this->patch($post->path(), $post->toArray())->assertRedirect('login');
        //show
        $this->get($post->path())->assertRedirect('login');
        //delete
        $this->delete($post->path())->assertRedirect('login');
    }
}
