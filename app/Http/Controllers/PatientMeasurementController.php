<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueryPatientMeasurementRequest;
use App\Http\Requests\StorePatientMeasurementRequest;
use App\Http\Requests\UpdatePatientMeasurementRequest;
use App\Models\PatientMeasurement;
use App\Repositories\PatientMeasurementRepository;
use Illuminate\Http\JsonResponse;

class PatientMeasurementController extends Controller
{
	/**
	 * Display a listing of the resource.
	 * 
	 * @param  \App\Http\Requests\QueryPatientMeasurementRequest $request
	 * @param  int $measurementTypeId 
	 * @param  int $patientId 
	 * @return \Illuminate\Http\Response
	 */
	public function index(QueryPatientMeasurementRequest $request, $patientId) : JsonResponse
	{
		try {
			$patientMeasurements = PatientMeasurementRepository::find($patientId);

			return $this->successResponse($patientMeasurements);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StorePatientMeasurementRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StorePatientMeasurementRequest $request, $patientId) : JsonResponse
	{
		try {
			$validated = $request->safe()->only([
				'value',
				'measuredAt',
				'measurementTypeId',
			]);

			$patientMeasurement = PatientMeasurement::create([
				'value' => $validated['value'],
				'measuredAt' => $validated['measuredAt'],
				'measurementTypeId' => $validated['measurementTypeId'],
				'patientId' => $patientId,
			]);

			$patientMeasurement = PatientMeasurementRepository::findById($patientId, $patientMeasurement->id);

			return $this->successResponse($patientMeasurement, $this->statuses()->CREATED);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Http\Requests\QueryPatientMeasurementRequest $request
	 * @param  int $patientId 
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(QueryPatientMeasurementRequest $request, $patientId, int $id) : JsonResponse
	{
		try {
			$patientMeasurement = PatientMeasurementRepository::findById($patientId, $id);

			return $this->successResponse($patientMeasurement);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\QueryPatientMeasurementRequest $request
	 * @param  int $patientId 
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePatientMeasurementRequest $request, $patientId, int $id) : JsonResponse
	{
		try {
			$validated = $request->safe()->only([
				'value',
				'measurementTypeId',
			]);

			$patientMeasurement = PatientMeasurementRepository::findById($patientId, $id);

			if (!$patientMeasurement)
				return $this->notFound('Patient measurement');

			if ($this->hasAttribute('value', $validated))
				$patientMeasurement->value = $validated['value'];

			if ($this->hasAttribute('measurementTypeId', $validated))
				$patientMeasurement->measurementTypeId = $validated['measurementTypeId'];

			$patientMeasurement->save();

			$patientMeasurement = PatientMeasurementRepository::findById($patientId, $id);

			return $this->successResponse($patientMeasurement);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Http\Requests\QueryPatientMeasurementRequest $request
	 * @param  int $patientId 
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(QueryPatientMeasurementRequest $request, $patientId, int $id) : JsonResponse
	{
		try {
			$patientMeasurement = PatientMeasurementRepository::findById($patientId, $id);

			if (!$patientMeasurement)
				return $this->notFound('Patient measurement');

			$patientMeasurement->delete();
			$patientMeasurement->save();

			return $this->successResponse();
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}
}
