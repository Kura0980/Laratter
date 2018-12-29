<?php

use Faker\Generator as Faker;

$factory->define(App\Like::class, function (Faker $faker) {
    $userIds  = App\User::pluck('id')->all();
    $postIds  = App\Post::pluck('id')->all();

    return [
        'user_id' => $faker->randomElement($userIds),
        'post_id' => $faker->randomElement($postIds)
    ];
});
