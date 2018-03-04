<?php

use Faker\Generator as Faker;
use App\Models\Message;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'subject' => $faker->randomAscii,
        'message' => $faker->text(255)
    ];
});