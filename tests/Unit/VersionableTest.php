<?php

namespace ProAI\Versioning\Tests\Unit;

use Carbon\Carbon;
use ProAI\Versioning\Tests\Models\User;
use ProAI\Versioning\Tests\TestCase;

/**
 * Class VersionableTest
 *
 * @package ProAI\Versioning\Tests\Unit
 */
class VersionableTest extends TestCase
{
    /**
    * @test
    */
    public function itWillVersionModelsWhenCreating(): void
    {
        /** @var User $model */
        $model = factory(User::class)->create([]);

        $this->assertDatabaseHas($model->getTable(), [
            'id'        => $model->id,
            'username'  => $model->username,
        ]);

        $this->assertDatabaseHas($model->getVersionTable(), [
            'ref_id'    => $model->id,
            'version'   => $model->latest_version,
            'email'     => $model->email,
            'city'      => $model->city
        ]);
    }

    /**
    * @test
    */
    public function itWillVersionModelsWhenUpdating(): void
    {
        /** @var User $model */
        $model = factory(User::class)->create([]);
        $email = $model->email;

        $model->update([
            'email'     => 'rick@wubba-lubba-dub.dub'
        ]);

        $this->assertDatabaseHas($model->getTable(), [
            'username'  => $model->username,
        ]);

        $this->assertDatabaseHas($model->getVersionTable(), [
            'ref_id'    => $model->id,
            'version'   => 1,
            'email'     => $email,
            'city'      => $model->city
        ]);

        $this->assertDatabaseHas($model->getVersionTable(), [
            'ref_id'    => $model->id,
            'version'   => 2,
            'email'     => $model->email,
            'city'      => $model->city
        ]);
    }

    /**
     * @test
     */
    public function itWillVersionModelsWhenSaving(): void
    {
        /** @var User $model */
        $model = factory(User::class)->create([]);
        $email = $model->email;

        $model->email = 'rick@wubba-lubba-dub.dub';
        $model->save();

        $this->assertDatabaseHas($model->getTable(), [
            'username'  => $model->username,
        ]);

        $this->assertDatabaseHas($model->getVersionTable(), [
            'ref_id'    => $model->id,
            'version'   => 1,
            'email'     => $email,
            'city'      => $model->city
        ]);

        $this->assertDatabaseHas($model->getVersionTable(), [
            'ref_id'    => $model->id,
            'version'   => 2,
            'email'     => $model->email,
            'city'      => $model->city
        ]);
    }

    /**
     * @test
     */
    public function itWillVersionModelsWhenInserting(): void
    {
        /** @var User $model */
        $model = factory(User::class)->make([]);
        $model->created_at = Carbon::now();
        $model->updated_at = Carbon::now();

        User::insert($model->toArray());

        $this->assertDatabaseHas($model->getTable(), [
            'id'        => 1,
            'username'  => $model->username,
        ]);

        $this->assertDatabaseHas($model->getVersionTable(), [
            'ref_id'    => 1,
            'version'   => 1,
            'email'     => $model->email,
            'city'      => $model->city
        ]);
    }

    /**
     * @test
     */
    public function itWillUpdateTheLatestVersionWhenCreating(): void
    {
        /** @var User $model */
        $model = factory(User::class)->create([]);

        $this->assertEquals(1, $model->latest_version);
    }

    /**
     * @test
     */
    public function itWillUpdateTheLatestVersionWhenUpdating(): void
    {
        /** @var User $model */
        $model = factory(User::class)->create([]);

        $model->update([
            'email'     => 'rick@wubba-lubba-dub.dub'
        ]);

        $this->assertEquals(2, $model->latest_version);
    }

    /**
     * @test
     */
    public function itWillUpdateTheLatestVersionWhenSaving(): void
    {
        /** @var User $model */
        $model = factory(User::class)->create([]);

        $model->email = 'rick@wubba-lubba-dub.dub';
        $model->save();

        $this->assertEquals(2, $model->latest_version);
    }

    /**
     * @test
     */
    public function itWillOnlyVersionVersionedAttributes(): void
    {
        /** @var User $model */
        $model = factory(User::class)->create([]);
        $email = $model->email;

        $model->email = 'rick@wubba-lubba-dub.dub';
        $model->username = 'RickSanchez';
        $model->save();

        $this->assertDatabaseHas($model->getTable(), [
            'username'  => 'RickSanchez',
        ]);

        $this->assertDatabaseHas($model->getVersionTable(), [
            'ref_id'    => $model->id,
            'version'   => 1,
            'email'     => $email,
            'city'      => $model->city
        ]);

        $this->assertDatabaseHas($model->getVersionTable(), [
            'ref_id'    => $model->id,
            'version'   => 2,
            'email'     => $model->email,
            'city'      => $model->city
        ]);
    }
}
