<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sale
 * 
 * @property int $id
 * @property Carbon|null $from
 * @property Carbon|null $to
 * @property int|null $product_detail_id
 * @property float|null $sale_price
 * 
 * @property ProductDetail|null $product_detail
 *
 * @package App\Models
 */
class Sale extends Model
{
	public $timestamps = false;

	protected $casts = [
		// 'id' => 'int',
		// 'from' => 'datetime',
		// 'to' => 'datetime',
		// 'product_detail_id' => 'int',
		// 'sale_price' => 'float'
	];

	protected $fillable = [
		'from_time',
		'to_time',
		'product_detail_id',
		'sale_price'
	];

	public function product_detail()
	{
		return $this->belongsToMany(ProductDetail::class);
	}
}
