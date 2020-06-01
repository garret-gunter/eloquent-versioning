<?php

namespace ProAI\Versioning\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use ProAI\Versioning\Versionable;

/**
 * Class Comment
 *
 * A model without versioned timestamps.
 *
 * @package ProAI\Versioning\Tests\Models
 *
 * @property int $id
 * @property string $latest_version
 * @property string $content
 * @property string $title
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Comment extends Model {
	use Versionable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'content', 'latest_version', 'title',
	];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	public $versioned = ['content'];
}
