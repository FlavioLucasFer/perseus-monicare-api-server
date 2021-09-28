<?php

namespace App\Http\Requests;

class StorePatientMeasurementRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'patient_id' => 'required|int|exists:App\Models\Patient,id|exists:App\Models\User,id,deleted_at,NULL',
			'measurementTypeId' => 'required|int|exists:App\Models\MeasurementType,id,deleted_at,NULL',
			'value' => 'required|numeric',
			'measuredAt' => 'required|date',
		];
	}

	public function validationData()
	{
		return array_merge($this->all(), $this->route()->parameters());
	}
}
