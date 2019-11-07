<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('posts', 'PostsController')->except(['show']);
    Route::get('posts/{post}/{slug}', 'PostsController@show')->name('posts.show');
    Route::resource('categories', 'CategoriesController')->except(['show']);
    Route::get('categories/{category}/{slug}', 'CategoriesController@show')->name('categories.show');
    Route::resource('comments', 'CommentsController');
});
