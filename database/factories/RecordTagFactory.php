<?php

use Faker\Generator as Faker;

$factory->define(App\RecordTag::class, function (Faker $faker) {
    return [
        'record_id' => $faker->numberBetween(1, config('default.seeds.record.number')),
        'tag_id' => $faker->numberBetween(1, config('default.seeds.tag.number')),
    ];
});
