<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\PostFactory;
use Tests\TestCase;

class ManagePostTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_posts()
    {
        $post = PostFactory::create();
        //index
        $this->get(route('posts.index'))->assertRedirect('login');
        //create
        $this->get(route('posts.create'))->assertRedirect('login');
        //store
        $this->post(route('posts.store'), $post->toArray())->assertRedirect('login');
        //edit
        $this->get(route('posts.edit', $post->id))->assertRedirect('login');
        //update
        $this->patch(route('posts.update', $post->id), $post->toArray())->assertRedirect('login');
        //show
        $this->get($post->path())->assertRedirect('login');
        //delete
        $this->delete(route('posts.destroy', $post->id))->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_see_all_posts()
    {
        // given we're signed in
        $post = PostFactory::ownedBy($this->signIn())->create();
        // when i visit All Post
        // i should see that post
        $this->get('/posts')
        ->assertSee($post->title)
        ->assertSee($post->body);
    }

    /** @test */
    public function a_user_can_create_a_post()
    {
        $this->signIn();
        $this->get(route('posts.create'))->assertStatus(200);

        $attributes = PostFactory::ownedBy($this->signIn())->raw();
        $response = $this->post('/posts', $attributes);
        $post = Post::where($attributes)->first();
        // $response->assertRedirect($post->path());
        $this->get($post->path())
        ->assertSee($post->title)
        ->assertSee($post->body);
    }

    /** @test */
    public function a_user_can_view_their_post()
    {
        $this->withoutExceptionHandling();
        $post = PostFactory::ownedBy($this->signIn())->create();
        $this->get($post->path())
        ->assertSee($post->title)
        ->assertSee($post->body)
        ->assertOk();
    }

    /** @test */
    public function a_user_can_update_a_post()
    {
        $attributes = ['title' => 'changed', 'body' => 'changed'];
        $post = PostFactory::ownedBy($this->signIn())->create();
        $this->get(route('posts.edit', $post->id))->assertOk();
        $this->patch(route('posts.update', $post->id), $attributes);
        // ->assertRedirect($post->path());
        $this->assertDatabaseHas('posts', $attributes);
    }

    /** @test */
    public function a_user_can_delete_a_post()
    {
        $post = PostFactory::ownedBy($this->signIn())->create();
        $this->delete(route('posts.destroy', $post->id));
        // ->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', $post->only('id'));
    }
}
