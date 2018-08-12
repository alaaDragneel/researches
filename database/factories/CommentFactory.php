<?php

use Faker\Generator as Faker;

$factory->define(MixCode\Comment::class, function (Faker $faker) {
        $user = factory(MixCode\User::class)->create();
        $post = factory(MixCode\Post::class)->create();

    return [
    	'user_id' => $user->id,
    	'post_id' => $post->id,
        'body' => $faker->sentence,
    ];
});
