<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeasurementTypeRequest;
use App\Http\Requests\UpdateMeasurementTypeRequest;
use App\Models\MeasurementType;
use App\Repositories\MeasurementTypeRepository;

class MeasurementTypeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$measurementTypes = MeasurementTypeRepository::find();

			return $this->successResponse($measurementTypes);
		} catch (\PDOException $e) {
			$this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreMeasurementTypeRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreMeasurementTypeRequest $request)
	{
		try {
			$validated = $request->safe()->only(['name']);

			$measurementType = MeasurementType::create([
				'name' => $validated['name'],
			]);

			return $this->successResponse($measurementType, $this->statuses()->CREATED);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(int $id)
	{
		try {
			$measurementType = MeasurementTypeRepository::findById($id);

			return $this->successResponse($measurementType);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateMeasurementTypeRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateMeasurementTypeRequest $request, int $id)
	{
		try {
			$measurementType = MeasurementTypeRepository::findById($id);

			if (!$measurementType)
				return $this->notFound('Measurement type');

			$validated = $request->safe()->only(['name']);

			if ($this->hasAttribute('name', $validated))
				$measurementType->name = $validated['name'];

			$measurementType->save();

			return $this->successResponse($measurementType);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(int $id)
	{
		try {
			$measurementType = MeasurementTypeRepository::findById($id);

			if (!$measurementType)
				return $this->notFound('Measurement type');

			$measurementType->delete();
			$measurementType->save();
		
			return $this->successResponse();
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}
}
