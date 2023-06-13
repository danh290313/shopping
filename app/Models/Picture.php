<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Picture
 * 
 * @property int $Id
 * @property string $source
 * @property int|null $product_id
 * @property int|null $color_id
 * @property int|null $collection_id
 * 
 * @property Product|null $product
 * @property Collection|ProductDetail[] $product_details
 *
 * @package App\Models
 */
class Picture extends Model
{
	protected $table = 'picture';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'color_id' => 'int',
		'collection_id' => 'int'
	];

	protected $fillable = [
		'source',
		'product_id',
		'color_id',
		'collection_id'
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
