<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
  protected $table = 'doctors';

	public $timestamps = false;

	protected $fillable = [
		'id',
		'crm',
		'specialty',
		'email',
	];

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
		return $this->hasOne(User::class, 'id', 'id');
	}
}
