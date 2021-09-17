<?php

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository implements RepositoryTemplate
{
	public static function find()
	{
		return Doctor::with('user')
			->has('user')
			->get();
	}

	public static function findById(int $id)
	{
		return Doctor::with('user')
			->has('user')
			->find($id);
	}
}