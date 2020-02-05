<?php

namespace ProAI\Versioning\Tests\Unit;

use ProAI\Versioning\Tests\Models\Post;
use ProAI\Versioning\Tests\Models\User;
use ProAI\Versioning\Tests\TestCase;

/**
 * Class SoftDeletesTest
 *
 * @package ProAI\Versioning\Tests
 */
class SoftDeletesTest extends TestCase {

	/**
	 * @test
	 *
	 * @dataProvider modelProvider
	 * @param string $model
	 * @throws \Exception
	 */
	public function itWillSaveDeletedAt(string $model): void {
		$model = factory($model)->create([]);
		$model->delete();

		$version = $model::withTrashed()->first();

		$this->assertEquals($model->id, $version->id);
		$this->assertEquals($model->deleted_at, $version->deleted_at);
	}

	/**
	 * @test
	 */
	public function itWillGetTheCorrectDeletedAtColumnOnTheMainTable(): void {
		/** @var Post $model */
		$model = factory(Post::class)->create([]);

		$this->assertEquals('posts.deleted_at', $model->getQualifiedDeletedAtColumn());
	}

	/**
	 * @test
	 */
	public function itWillGetTheCorrectDeletedAtColumnOnTheVersionTable(): void {
		/** @var User $model */
		$model = factory(User::class)->create([]);

		$this->assertEquals('users_version.deleted_at', $model->getQualifiedDeletedAtColumn());
	}

	/**
	 * @test
	 * @throws \Exception
	 */
	public function itWillSaveDeletedAtInTheMainTable(): void {
		/** @var Post $model */
		$model = factory(Post::class)->create([]);
		$model->delete();

		$this->assertDatabaseHas('posts', [
			'id'            => $model->id,
			'deleted_at'    => $model->deleted_at
		]);
	}

	/**
	 * @test
	 * @throws \Exception
	 */
	public function itWillSaveDeletedAtInTheVersionTable(): void {
		/** @var User $model */
		$model = factory(User::class)->create([]);
		$model->delete();

		$this->assertDatabaseHas('users_version', [
			'ref_id'        => $model->id,
			'version'       => 1,
			'deleted_at'    => null
		]);

		$this->assertDatabaseHas('users_version', [
			'ref_id'        => $model->id,
			'version'       => 2,
			'deleted_at'    => $model->deleted_at->format('Y-m-d H:i:s')
		]);
	}

	/**
	 * @return array
	 */
	public function modelProvider(): array {
		return [
			[
				User::class
			],
			[
				Post::class
			]
		];
	}
}
