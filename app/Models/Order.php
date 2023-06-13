<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property bool|null $paid
 * @property string|null $note
 * @property int $status
 * @property int|null $user_id
 * 
 * @property Collection|OrderDetail[] $order_details
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'order';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'paid' => 'bool',
		'status' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'paid',
		'note',
		'status',
		'user_id'
	];

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}
}
