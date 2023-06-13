<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $Id
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
	protected $table = 'product';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'update_at' => 'datetime'
	];

	protected $fillable = [
		'name',
		'brand',
		'description',
		'update_at'
	];

	public function colors()
	{
		return $this->hasMany(Color::class);
	}

	public function pictures()
	{
		return $this->hasMany(Picture::class);
	}

	public function product_details()
	{
		return $this->hasMany(ProductDetail::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class)
					->withPivot('Id');
	}

	public function sizes()
	{
		return $this->hasMany(Size::class);
	}
}
