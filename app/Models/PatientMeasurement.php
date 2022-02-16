<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMeasurement extends Model
{
	use SoftDeletes;

  protected $table = 'patient_measurements';

	protected $fillable = [
		'value',
		'measuredAt',
		'patientId',
		'measurementTypeId',
	];

	protected $maps = [
		'measured_at' => 'measuredAt',
		'patient_id' => 'patientId',
		'measurement_type_id' => 'measurementTypeId',
	];

	protected $append = [
		'measuredAt',
		'patientId',
		'measurementTypeId',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at',
		'measured_at',
		'patient_id',
		'measurement_type_id',
	];

	public function setValueAttribute($value)
	{
		if ($value)
			$this->attributes['value'] = $value;
	}

	public function getMeasuredAtAttribute()
	{
		return $this->attributes['measured_at'];
	}

	public function setMeasuredAtAttribute($value)
	{
		$this->attributes['measured_at'] = $value;
	}

	public function setMeasurementTypeIdAttribute($value)
	{
		$this->attributes['measurement_type_id'] = $value;
	}

	public function setPatientIdAttribute($value)
	{
		$this->attributes['patient_id'] = $value;
	}

	public function patient()
	{
		return $this->hasOne(Patient::class, 'id', 'patient_id');
	}

	public function measurement()
	{
		return $this->hasOne(MeasurementType::class, 'id', 'measurement_type_id');
	}
}
