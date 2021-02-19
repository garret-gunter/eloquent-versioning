<?php

use Faker\Generator as Faker;
use BinaryCocoa\Versioning\Tests\Models\Post;

/*
|--------------------------------------------------------------------------
| Post Factories
|--------------------------------------------------------------------------
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Post::class, function (Faker $faker) {
	return [
		'title'         => $faker->title,
		'content'          => $faker->text,
	];
});
