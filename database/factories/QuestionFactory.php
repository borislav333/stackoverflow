<?php

use Faker\Generator as Faker;

$factory->define(\App\Question::class, function (Faker $faker) {
    $title=rtrim($faker->sentence(rand(5,10)),'.');
    return [
        'title'=>$title,
        'slug'=>str_slug($title),
        'body'=>$faker->paragraphs(rand(3,7),true),
        'views'=>rand(0,10),
        //'answers_count'=>rand(0,10),
        //'votes_count'=>rand(-3,10),
    ];
});
