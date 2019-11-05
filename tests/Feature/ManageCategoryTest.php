<?php

namespace Tests\Feature;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Blog\Repositories\Factory\CategoryFactory;

class ManageCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cannot_manage_categories()
    {
        $category = $this->createfactory(new CategoryFactory());
        //index
        $this->get(route('categories.index'))->assertRedirect('login');
        //create
        $this->get(route('categories.create'))->assertRedirect('login');
        //store
        $this->post(route('categories.store'), $category->toArray())->assertRedirect('login');
        //edit
        $this->get(route('categories.edit', $category->id))->assertRedirect('login');
        //update
        $this->patch(route('categories.update', $category->id), $category->toArray())->assertRedirect('login');
        //show
        $this->get($category->path())->assertRedirect('login');
        //delete
        $this->delete(route('categories.destroy', $category->id))->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_see_all_categories()
    {
        $category = $this->createfactory(new CategoryFactory($this->signIn()));
        $this->get(route('categories.index'))
        ->assertSee($category->title)
        ->assertSee($category->body);
    }

    /** @test */
    public function a_user_can_create_a_category()
    {
        $user = $this->signIn();
        $this->get(route('categories.create'))->assertOk();

        $attributes = $this->rawFactory(new CategoryFactory($user));
        $response = $this->post('/categories', $attributes);
        $category = Category::where($attributes)->first();
        // $response->assertRedirect($category->path());
        $this->get($category->path())
        ->assertSee($category->title)
        ->assertSee($category->body);
    }

    /** @test */
    public function a_user_can_view_their_category()
    {
        $category = $this->createFactory(new CategoryFactory($this->signIn()));

        $this->get($category->path())
        ->assertSee($category->title)
        ->assertSee($category->body)
        ->assertOk();
    }

    /** @test */
    public function a_user_can_update_a_category()
    {
        $attributes = ['name' => 'changed', 'description' => 'changed'];
        $category = $this->createFactory(new CategoryFactory($this->signIn()));
        $this->get(route('categories.edit', $category->id))->assertOk();
        $this->patch(route('categories.update', $category->id), $attributes);
        // ->assertRedirect($category->path());
        $this->assertDatabaseHas('categories', $attributes);
    }

    /** @test */
    public function a_user_can_delete_a_category()
    {
        $category = $this->createFactory(new CategoryFactory($this->signIn()));

        $this->delete(route('categories.destroy', $category->id));
        // ->assertRedirect(route('categories.index'));
        $category->refresh();
        $this->assertDatabaseHas('categories', $category->only('deleted_at'));
    }

    /** @test */
    public function an_authenticated_user_cannot_manage_the_categories_of_others()
    {
        $this->signIn();
        $category = $this->createFactory(new CategoryFactory());

        $this->get($category->path())->assertStatus(403);
        $this->patch(route('categories.update', $category->id))->assertStatus(403);
        $this->delete(route('categories.destroy', $category->id))->assertStatus(403);
    }
}
