<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'post_id' => factory(App\Post::class),
        'user_id' => factory(App\User::class),
        'ip' => $faker->ipv4(),
        'guest_name' => $faker->username(),
        'guest_email' => $faker->email(),
        'body' => $faker->sentence(),
        'approved' => true
    ];
});
