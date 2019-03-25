<?php

use Faker\Generator as Faker;

$factory->define(App\RecordTag::class, function (Faker $faker) {
    return [
        'record_id' => $faker->numberBetween(1, config('seeds.record.number')),
        'tag_id' => $faker->numberBetween(1, config('seeds.tag.number')),
    ];
});
