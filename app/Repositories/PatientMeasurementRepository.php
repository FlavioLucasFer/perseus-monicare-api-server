<?php

namespace App\Repositories;

use App\Models\PatientMeasurement;

class PatientMeasurementRepository
{
	public static function find(int $patientId)
	{
		return PatientMeasurement::with(['measurement', 'patient', 'patient.user'])
			->where('patient_id', '=', $patientId)
			->get(['*', 'measured_at AS measuredAt']);
	}

	public static function findById(int $patientId, int $id)
	{
		return PatientMeasurement::with(['measurement', 'patient', 'patient.user'])
			->where('patient_id', '=', $patientId)
			->find($id, ['*', 'measured_at AS measuredAt']);
	}
}
