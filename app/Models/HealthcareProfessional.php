<?php

namespace App\Models;

use App\Exceptions\CustomExceptions;

use Illuminate\Database\Eloquent\Model;

class HealthcareProfessional extends Model
{
  protected $table = 'healthcare_professionals';

	public $timestamps = false;

	public function setEmailAttribute($value) 
	{
		
		if ($value) {
			if (filter_var($value, FILTER_VALIDATE_EMAIL))
				$this->attributes['email'] = $value;
			else
				CustomExceptions::invalidEmail();			
		}
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id', 'id')->withTrashed();
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
			'type' => $this->user->type,
			'created_at' => $this->user->created_at,
			'updated_at' => $this->user->updated_at,
		];
	}
}
