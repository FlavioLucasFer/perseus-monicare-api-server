<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasurementType extends Model
{
	use SoftDeletes;

  protected $table = 'measurement_types';

	protected $fillable = [
		'name',
		'optimum',
		'highest',
		'lowest',
		'maxBorder',
		'minBorder',
	];

	protected $maps = [
		'max_border' => 'minBorder',
		'min_border' => 'maxBorder',
	];

	protected $append = [
		'minBorder',
		'maxBorder',
	];

	protected $dates = [
		'deleted_at',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at',
		'optimum',
		'highest',
		'lowest',
		'max_border',
		'min_border',
		'minBorder',
		'maxBorder',
	];

	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	public function setNameAttribute($value)
	{
		if ($value)
			$this->attributes['name'] = $value;
	}

	public function getMinBorderAttribute()
	{
		return $this->attributes['min_border'];
	}

	public function setMinBorderAttribute($value)
	{
		$this->attributes['min_border'] = $value;
	}
	
	public function setMaxBorderAttribute($value)
	{
		$this->attributes['max_border'] = $value;
	}

	public function getMaxBorderAttribute()
	{
		return $this->attributes['max_border'];
	}
}
