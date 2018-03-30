<?php

use Faker\Generator as Faker;
use App\Models\Message;
use App\Models\Person;
use App\Models\Client;


$factory->define(Message::class, function (Faker $faker) {
    return [
        'subject' => $faker->text(25),
        'message' => $faker->text(255),
        'sender_id' => function () {
            return Person::inRandomOrder()->first();
        },
        'receiver_id' => function () {
            return Person::inRandomOrder()->first();
        },
        'sender_client_id' => function () {
            return Client::inRandomOrder()->first();
        },
        'receiver_client_id' => function () {
            return Client::inRandomOrder()->first();
        }
    ];
});