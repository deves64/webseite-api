<?php

use Faker\Generator as Faker;
use App\Models\Client;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'client' => $faker->uuid,
        'typ' => $faker->randomElement(['website', 'app']),
        'embedded' => $faker->randomElement(['david-atayee.de', 'david-atayee.eu', 'david-atayee.com', 'blue-solution.de', 'blue-solution.eu', 'blue-solution.com']),
        'designation' => $faker->randomElement(['contact', 'questions', 'inquire', 'meeting']),
    ];
});