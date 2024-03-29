<?php

use Faker\Generator as Faker;
use App\Models\Person;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'forename' => $faker->firstName,
        'surname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber
    ];
});