<?php

namespace App\Repositories;

use App\Models\PatientMeasurement;

class PatientMeasurementRepository
{
	public static function find(int $measurementTypeId, int $patientId)
	{
		return PatientMeasurement::with(['measurement', 'patient', 'patient.user'])
			->where('measurement_type_id', '=', $measurementTypeId)
			->where('patient_id', '=', $patientId)
			->get(['*', 'measured_at AS measuredAt']);
	}

	public static function findById(int $id)
	{
		return PatientMeasurement::with(['measurement', 'patient', 'patient.user'])
			->find($id, ['*', 'measured_at AS measuredAt']);
	}
}
