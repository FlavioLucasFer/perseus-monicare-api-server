<?php

namespace App\Models;

use App\Exceptions\CustomExceptions;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
	protected $table = 'patient';

	public $timestamps = false;

	protected $maps = [
		'birth_date' => 'birthDate',
	];

	protected $append = [
		'birthDate',
	];

	protected $hidden = [
		'birth_date',
	];

	public function getBirthDateAttribute() {
		return $this->attributes['birth_date'];
	}

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
			'birthDate' => $this->getBirthDateAttribute(),
			'email' => $this->attributes['email'],
			'type' => $this->user->type,
			'createdAt' => $this->user->createdAt,
			'updatedAt' => $this->user->updatedAt,
		];
	}
}
