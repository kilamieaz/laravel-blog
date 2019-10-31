<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    $sentence = $faker->sentence(2);
    return [
        'slug' => Str::slug($sentence),
        'title' => $sentence,
        'body' => $sentence,
        'published' => false
    ];
});
