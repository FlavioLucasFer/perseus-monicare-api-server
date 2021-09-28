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
	];

	protected $dates = [
		'deleted_at',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at',
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
}
