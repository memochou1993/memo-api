<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName(),
        'user_id' => $faker->numberBetween(1, config('default.seeds.user.number')),
    ];
});
