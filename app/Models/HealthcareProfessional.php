<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthcareProfessional extends Model
{
  protected $table = 'healthcare_professionals';

	public $timestamps = false;

	protected $fillable = [
		'id',
		'email',
	];

	public function setEmailAttribute($value) 
	{
		if ($value) 
			$this->attributes['email'] = $value;
	}

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'id');
	}
}
