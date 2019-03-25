<?php

use Faker\Generator as Faker;

$factory->define(App\Record::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'content' => $faker->paragraph(),
        'user_id' => $faker->numberBetween(1, config('seeds.user.number')),
        'type_id' => $faker->numberBetween(1, count(config('factories.type'))),
        'created_at'  => now()->subDays($faker->randomDigit())->toDateTimeString(),
        'updated_at'  => now()->subDays($faker->randomDigit())->toDateTimeString(),
    ];
});
