<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Question::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,3),
        'tag_category_id' => rand(1,4),
        'title' => $faker->title,
        'content' => $faker->text,
    ];
});
