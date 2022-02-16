<?php

namespace App\Repositories;

use App\Models\PatientMeasurement;
use Illuminate\Support\Facades\DB;

class PatientMeasurementRepository
{
	public static function find(int $patientId)
	{
		return PatientMeasurement::with(['measurement', 'patient', 'patient.user'])
			->join('measurement_types AS mt', 'patient_measurements.measurement_type_id', 'mt.id')
			->where('patient_measurements.patient_id', '=', $patientId)
			->get([
				'patient_measurements.*',
				DB::raw("DATE_FORMAT(patient_measurements.measured_at, '%d/%m/%Y %H:%i:%s') AS measuredAt"),
				DB::raw("
					CASE
						WHEN patient_measurements.value > mt.highest OR patient_measurements.value < mt.lowest THEN 'bad'
						WHEN patient_measurements.value > mt.max_border OR patient_measurements.value < mt.min_border THEN 'caution'
						ELSE 'good'
					END AS status
				"),
			]);
	}

	public static function findById(int $patientId, int $id)
	{
		return PatientMeasurement::with(['measurement', 'patient', 'patient.user'])
			->join('measurement_types AS mt', 'patient_measurements.measurement_type_id', 'mt.id')
			->where('patient_measurements.patient_id', '=', $patientId)
			->find($id, [
				'patient_measurements.*',
				DB::raw("DATE_FORMAT(patient_measurements.measured_at, '%d/%m/%Y %H:%i:%s') AS measuredAt"),
				DB::raw("
					CASE
						WHEN patient_measurements.value > mt.highest OR patient_measurements.value < mt.lowest THEN 'bad'
						WHEN patient_measurements.value > mt.max_border OR patient_measurements.value < mt.min_border THEN 'caution'
						ELSE 'good'
					END AS status
				"),
			]);
	}
}
