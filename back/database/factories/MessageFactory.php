<?php

declare(strict_types=1);

use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Message::class, function (Faker $faker) {
    return [
        'content' => $faker->sentences(
            random_int(1, 10), true
        ),
    ];
});
