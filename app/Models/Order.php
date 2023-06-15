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

	protected $casts = [
		// 'id' => 'int',
		// 'paid' => 'bool',
		// 'status' => 'string',
		// 'user_id' => 'int',
		'shipped_at' => 'datetime:Y-m-d H:m:s',
		'created_at' => 'datetime:Y-m-d H:m:s',
		'updated_at' => 'datetime:Y-m-d H:m:s',
	];

	protected $fillable = [
		'paid',
		'status',
		'user_id',
		'shipped_at'
	];

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}
}
