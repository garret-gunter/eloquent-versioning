<?php

use Faker\Generator as Faker;
use ProAI\Versioning\Tests\Models\Comment;

/*
|--------------------------------------------------------------------------
| Comment Factories
|--------------------------------------------------------------------------
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Comment::class, static function (Faker $faker) {
	return [
		'title' => $faker->sentence,
		'content' => $faker->text,
	];
});
