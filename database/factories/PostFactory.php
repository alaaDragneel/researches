<?php

use Faker\Generator as Faker;

$factory->define(MixCode\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'user_id' => 1,
    ];
});
