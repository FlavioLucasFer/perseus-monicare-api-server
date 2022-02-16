<?php

namespace App\Repositories;

use App\Models\HealthcareProfessional;

class HealthcareProfessionalRepository implements RepositoryTemplate
{
	public static function find()
	{
		return HealthcareProfessional::with('user')
			->has('user')
			->get();
	}

	public static function findById(int $id)
	{
		return HealthcareProfessional::with('user')
			->has('user')
			->find($id);
	}
}
