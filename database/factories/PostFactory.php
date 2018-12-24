<?php

use Faker\Generator as Faker;
$factory->define(App\Post::class, function (Faker $faker) {
    $userIDs  = App\User::pluck('id')->all();

    return [
        'user_id' => $faker->randomElement($userIDs),
        'sentence' => $faker->sentence
    ];
});
