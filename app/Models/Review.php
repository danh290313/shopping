<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * 
 * @property int $Id
 * @property string $titile
 * @property string $content
 * @property Carbon $created_at
 * @property int $user_id
 * @property int $rating
 * 
 * @property User $user
 * @property Collection|OrderDetail[] $order_details
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'review';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'rating' => 'int'
	];

	protected $fillable = [
		'titile',
		'content',
		'user_id',
		'rating'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}
}
