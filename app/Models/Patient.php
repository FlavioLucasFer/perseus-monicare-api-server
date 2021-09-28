<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
	protected $table = 'patients';

	public $timestamps = false;

	protected $fillable = [
		'id',
		'birthDate',
		'email',
	];

	protected $maps = [
		'birth_date' => 'birthDate',
	];

	protected $append = [
		'birthDate',
	];

	protected $hidden = [
		'birth_date',
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

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'id');
	}

	public function caregivers()
	{
		return $this->hasMany(Caregiver::class, 'patient_id', 'id');
	}
}
