<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
	use SoftDeletes;

	protected $table = 'users';

	protected $dates = ['deleted_at'];

	protected $maps = [
		'created_at' => 'createdAt',
		'updated_at' => 'updatedAt',
	];

	protected $append = [
		'createdAt',
		'updatedAt',
	];

	protected $hidden = [
		'password',
		'remember_token',
		'created_at',
		'updated_at',
	];

	public function getCreatedAtAttribute() 
	{
		return $this->attributes['created_at'];
	}

	public function getUpdatedAtAttribute() 
	{
		return $this->attributes['updated_at'];
	}

	public function setNameAttribute($value)
	{
		if ($value)
			$this->attributes['name'] = $value;
	}

	public function setLoginAttribute($value)
	{
		if ($value)
			$this->attributes['login'] = $value;
	}

	public function setPasswordAttribute($value) 
	{
		if ($value)
			$this->attributes['password'] = Hash::make($value);
	}

	public function setCpfAttribute($value)
	{
		if ($value)
			$this->attributes['cpf'] = $value;
	}

	public function setPhoneAttribute($value)
	{	
		if ($value) 
			$this->attributes['phone'] = $value;
	}

	public function setTypeAttribute($value)
	{
		if ($value) {
			if (
				$value === "AD" ||
				$value === "PT" ||
				$value === "DC" ||
				$value === "CG" ||
				$value === "HP"
			) {
				$this->attributes['type'] = $value;
			}
			else
				throw new Exception('Invalid user type');
		}
	}
}
