<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
  protected $table = 'caregivers';

	public $timestamps = false;

	protected $fillable = [
		'id',
		'birthDate',
		'kinship',
		'email',
		'patientId',
	];

	protected $maps = [
		'birth_date' => 'birthDate',
		'patient_id' => 'patientId',
	];

	protected $append = [
		'birthDate',
		'patientId',
	];

	protected $hidden = [
		'birth_date',
		'patient_id',
	];

	public function getBirthDateAttribute()
	{
		return $this->attributes['birth_date'];
	}

	
	public function setBirthDateAttribute($value)
	{
		if ($value)
			$this->attributes['birth_date'] = $value;
	}
	
	public function setKinshipAttribute($value)
	{
		if ($value)
			$this->attributes['kinship'] = $value;
	}

	public function getEmailAttribute()
	{
		if (array_key_exists('email', $this->attributes))
			return $this->attributes['email'];

		return null;
	}

	public function setEmailAttribute($value)
	{
		if ($value)
			$this->attributes['email'] = $value;
	}

	public function setPatientIdAttribute($value)
	{
		if ($value)
			$this->attributes['patient_id'] = $value;
	}

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'id');
	}

	public function patient()
	{
		return $this->hasOne(Patient::class, 'id', 'patient_id');
	}
}
