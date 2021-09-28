<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthcareProfessional extends Model
{
  protected $table = 'healthcare_professionals';

	public $timestamps = false;

	public function setEmailAttribute($value) 
	{
		if ($value) 
			$this->attributes['email'] = $value;
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id', 'id');
	}

	public function toArray()
	{
		return [
			'id' => $this->user->id,
			'name' => $this->user->name,
			'login' => $this->user->login,
			'cpf' => $this->user->cpf,
			'phone' => $this->user->phone,
			'email' => $this->attributes['email'],
			'createdAt' => $this->user->createdAt,
			'updatedAt' => $this->user->updatedAt,
		];
	}
}
