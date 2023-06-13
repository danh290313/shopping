<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductDetail
 * 
 * @property int $id
 * @property int|null $product_id
 * @property int|null $color_id
 * @property int|null $picture_id
 * @property float|null $regular_price
 * @property int|null $quantity
 * 
 * @property Product|null $product
 * @property Picture|null $picture
 * @property Color|null $color
 * @property Collection|OrderDetail[] $order_details
 * @property Collection|Sale[] $sales
 *
 * @package App\Models
 */
class ProductDetail extends Model
{
	public $timestamps = false;

	protected $casts = [
		// 'id' => 'int',
		// 'product_id' => 'int',
		// 'color_id' => 'int',
		// 'picture_id' => 'int',
		// 'regular_price' => 'float',
		// 'quantity' => 'int'
	];

	protected $fillable = [
		'product_id',
		'color_id',
		'picture_id',
		'regular_price',
		'quantity'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function picture()
	{
		return $this->belongsTo(Picture::class);
	}

	public function color()
	{
		return $this->belongsTo(Color::class);
	}

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}
}
