<?php

namespace App\Models;

use Exception;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
	use Notifiable;

	use SoftDeletes;

	protected $table = 'users';

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'name',
		'login',
		'password',
		'cpf',
		'phone',
		'type',
	];

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
		'deleted_at',
		'id',
	];

	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
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

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}
}
