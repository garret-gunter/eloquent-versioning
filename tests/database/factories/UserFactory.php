<?php

use Faker\Generator as Faker;
use BinaryCocoa\Versioning\Tests\Models\User;

/*
|--------------------------------------------------------------------------
| User Factories
|--------------------------------------------------------------------------
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
	return [
		'email'         => $faker->unique()->safeEmail,
		'username'      => $faker->userName,
		'city'          => $faker->city
	];
});
