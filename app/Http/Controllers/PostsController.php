<?php

namespace App\Http\Controllers;

use App\Blog\Repositories\Eloquent\PostRepository;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    protected $repo;

    public function __construct()
    {
        // set the repo
        $this->repo = new PostRepository();
        // $this->repo = RepositoryReporter::report(new PostRepository);
        // authorize
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repo->latest();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        $request->merge(['slug' => slug($request->title)]);
        // create record and pass in only fields that are fillable
        return $this->repo->store($request->only($this->repo->getModel()->fillable));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $this->repo->show($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // update repo and only pass in the fillable fields
        $this->repo->update($request->only($this->repo->getModel()->fillable), $post);

        return $post->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return $this->repo->delete($post);
    }
}
