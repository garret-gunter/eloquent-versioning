<?php

namespace ProAI\Versioning\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use ProAI\Versioning\Versionable;
use ProAI\Versioning\SoftDeletes;

/**
 * Class User
 *
 * @package ProAI\Versioning\Tests\Models
 *
 * @property int $id
 * @property string $city
 * @property string $email
 * @property string $latest_version
 * @property string $password
 * @property string $remember_token
 * @property string $username
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable {
	use Versionable;
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'email', 'username', 'city', 'latest_version',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public $timestamps = true;

	public $versioned = ['email', 'city', 'updated_at', 'deleted_at'];
}
