<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $sentence = $faker->sentence(2);
    return [
        'user_id' => factory(App\User::class),
        'slug' => slug($sentence),
        'title' => $sentence,
        'body' => $sentence,
        'published' => false
    ];
});
