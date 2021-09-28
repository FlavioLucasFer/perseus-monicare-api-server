<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
  protected $table = 'doctors';

	public $timestamps = false;

	public function setCrmAttribute($value)
	{
		if ($value)
			$this->attributes['crm'] = $value;
	}

	public function setSpecialtyAttribute($value)
	{
		if ($value)
			$this->attributes['specialty'] = $value;
	}

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
			'crm' => $this->attributes['crm'],
			'specialty' => $this->attributes['specialty'],
			'email' => $this->attributes['email'],
			'createdAt' => $this->user->createdAt,
			'updatedAt' => $this->user->updatedAt,
		];
	}
}
