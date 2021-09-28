<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository implements RepositoryTemplate 
{
	public static function find()
	{
		return Patient::with('user')
			->with('caregivers')
			->with('caregivers.user')
			->has('user')
			->get(['*', 'birth_date AS birthDate']);
	}

	public static function findById(int $id)
	{
		return Patient::with('user')
			->with('caregivers')
			->with('caregivers.user')
			->has('user')
			->get(['*', 'birth_date AS birthDate'])
			->find($id);
	}
}