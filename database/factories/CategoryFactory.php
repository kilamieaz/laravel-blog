<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $sentence = $faker->sentence(2);
    return [
        'user_id' => factory(App\User::class),
        'name' => $sentence,
        'slug' => slug($sentence),
        'description' => 'description' . $sentence
    ];
});
