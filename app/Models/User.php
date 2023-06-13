<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $Id
 * @property string $name
 * @property string $email
 * @property string|null $provider
 * @property int|null $provider_id
 * @property string|null $access_token
 * @property string|null $session_token
 * 
 * @property Collection|Review[] $reviews
 *
 * @package App\Models
 */
class User extends Model
{
	use HasFactory;
	protected $table = 'user';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'provider_id' => 'int'
	];

	protected $hidden = [
		'access_token',
		'session_token'
	];

	protected $fillable = [
		'name',
		'email',
		'provider',
		'provider_id',
		'access_token',
		'session_token'
	];

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}
}
