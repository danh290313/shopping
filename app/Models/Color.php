<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Color
 * 
 * @property int $id
 * @property string $name
 * @property int $product_id
 * @property string $hex_value
 * 
 * @property Product $product
 * @property Collection|ProductDetail[] $product_details
 *
 * @package App\Models
 */
class Color extends Model
{
	protected $table = 'color';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int'
	];

	protected $fillable = [
		'name',
		'product_id',
		'hex_value'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function product_details()
	{
		return $this->hasMany(ProductDetail::class);
	}
}
