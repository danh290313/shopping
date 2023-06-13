<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductTag
 * 
 * @property int $Id
 * @property int $product_id
 * @property int $tag_id
 * 
 * @property Product $product
 * @property Tag $tag
 *
 * @package App\Models
 */
class ProductTag extends Model
{
	protected $table = 'product_tag';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'tag_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'tag_id'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
