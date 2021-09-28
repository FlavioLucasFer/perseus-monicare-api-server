<?php

namespace App\Repositories;

use App\Models\MeasurementType;

class MeasurementTypeRepository implements RepositoryTemplate
{
	public static function find()
	{
		return MeasurementType::all();
	} 

	public static function findById(int $id)
	{
		return MeasurementType::query()->find($id);
	}
}