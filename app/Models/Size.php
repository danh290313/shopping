<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Size
 * 
 * @property int $Id
 * @property string $name
 * @property int|null $product_id
 * 
 * @property Product|null $product
 *
 * @package App\Models
 */
class Size extends Model
{
	protected $table = 'size';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int'
	];

	protected $fillable = [
		'name',
		'product_id'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
