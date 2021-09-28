<?php

namespace App\Models;

use App\Exceptions\CustomExceptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

	public function getCreatedAtAttribute() {
		return $this->attributes['created_at'];
	}

	public function getUpdatedAtAttribute() {
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
		$validator = Validator::make(['cpf' => $value], [
			'cpf' => 'cpf|formato_cpf',
		]);

		if ($value) {
			if (!$validator->fails())
				$this->attributes['cpf'] = $value;
			else
				CustomExceptions::invalidCPF();
		}
	}

	public function setPhoneAttribute($value)
	{
		$validator = Validator::make(['phone' => $value], ['phone' => 'celular_com_ddd']);
		
		if ($value) {
			if (!$validator->fails())
				$this->attributes['phone'] = $value;
			else
				CustomExceptions::invalidPhone();
		} 
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
				CustomExceptions::invalidUserType();
		}
	}
}
