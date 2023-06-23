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
use App\Traits\TimeZone;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, TimeZone;
	protected $casts = [
		//'provider_id' => 'int'
	];

	protected $hidden = [
        'password',
        'remember_token',
    ];

	protected $fillable = [
		'name',
        'email',
        'password',
		'social_id',
		'social_provider',
		'avatar',
		
	];

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}
	public function orders(){
        return $this->hasMany(Order::class);
    }
}
