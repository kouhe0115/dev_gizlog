<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,3),
        'question_id' => rand(1,4),
        'comment' => $faker->text,
    ];
});
