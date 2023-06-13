<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * 
 * @property int $id
 * @property string $name
 * @property string $brand
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $update_at
 * 
 * @property Collection|Color[] $colors
 * @property Collection|Picture[] $pictures
 * @property Collection|ProductDetail[] $product_details
 * @property Collection|Tag[] $tags
 * @property Collection|Size[] $sizes
 *
 * @package App\Models
 */
class Product extends Model
{
	use SoftDeletes;
	protected $casts = [
	];

	protected $fillable = [
		'name',
		'brand',
		'description',
		'slug'
	];

	public function product_details()
	{
		return $this->hasMany(ProductDetail::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class)
					->withPivot('id');
	}

	public function sizes()
	{
		return $this->hasMany(Size::class);
	}
}
