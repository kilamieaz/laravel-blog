<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Blog\Repositories\Factory\PostFactory;
use Facades\App\Blog\Reporting\FactoryReporter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagePostTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_posts()
    {
        $post = FactoryReporter::create(new PostFactory());
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
        $post = FactoryReporter::create(new PostFactory($this->signIn()));
        // when i visit All Post
        // i should see that post
        $this->get(route('posts.index'))
        ->assertSee($post->title)
        ->assertSee($post->body);
    }

    /** @test */
    public function a_user_can_create_a_post()
    {
        $this->signIn();
        $this->get(route('posts.create'))->assertOk();

        $attributes = FactoryReporter::raw(new PostFactory($this->signIn()));
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
        $post = FactoryReporter::create(new PostFactory($this->signIn()));

        $this->get($post->path())
        ->assertSee($post->title)
        ->assertSee($post->body)
        ->assertOk();
    }

    /** @test */
    public function a_user_can_update_a_post()
    {
        $attributes = ['title' => 'changed', 'body' => 'changed'];
        $post = FactoryReporter::create(new PostFactory($this->signIn()));
        $this->get(route('posts.edit', $post->id))->assertOk();
        $this->patch(route('posts.update', $post->id), $attributes);
        // ->assertRedirect($post->path());
        $this->assertDatabaseHas('posts', $attributes);
    }

    /** @test */
    public function a_user_can_delete_a_post()
    {
        $post = FactoryReporter::create(new PostFactory($this->signIn()));

        $this->delete(route('posts.destroy', $post->id));
        // ->assertRedirect(route('posts.index'));
        $post->refresh();
        $this->assertDatabaseHas('posts', $post->only('deleted_at'));
    }

    /** @test */
    public function an_authenticated_user_cannot_manage_the_posts_of_others()
    {
        $this->signIn();
        $post = FactoryReporter::create(new PostFactory());

        $this->get($post->path())->assertStatus(403);
        $this->patch(route('posts.update', $post->id))->assertStatus(403);
        $this->delete(route('posts.destroy', $post->id))->assertStatus(403);
    }
}
