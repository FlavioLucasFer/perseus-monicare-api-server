<?php

namespace App\Repositories;

use App\Models\Caregiver;

/**
 * Class CaregiverRepository.
 */
class CaregiverRepository implements RepositoryTemplate
{
	/**
	 * Finds all caregivers
	 */
	public static function find()
	{
		return Caregiver::with('user')
			->with('patient')
			->with('patient.user')
			->has('user')
			->get(['*', 'birth_date AS birthDate']);
	}

	/**
	 * Finds one caregiver with the specified id 
	 * 
	 * @param int $id
	 */
	public static function findById(int $id)
	{
		return Caregiver::with('user')
			->with('patient')
			->with('patient.user')
			->has('user')
			->get(['*', 'birth_date AS birthDate'])
			->find($id);
	}
}
