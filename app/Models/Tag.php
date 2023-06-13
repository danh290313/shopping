<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * 
 * @property int $Id
 * @property string $name
 * @property int $collection_id
 * 
 * @property Collection $collection
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Tag extends Model
{
	protected $table = 'tag';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'collection_id' => 'int'
	];

	protected $fillable = [
		'name',
		'collection_id'
	];

	public function collection()
	{
		return $this->belongsTo(Collection::class);
	}

	public function products()
	{
		return $this->belongsToMany(Product::class)
					->withPivot('Id');
	}
}
