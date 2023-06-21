<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
/**
 * Class User
 * 
 * @property int $id
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
class Admin extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;
	protected $casts = [
		//'provider_id' => 'int'
	];

	protected $hidden = [
		'email_verified_at',
		'password',
		'remember_token',
		'created_at',
		'updated_at'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

}
