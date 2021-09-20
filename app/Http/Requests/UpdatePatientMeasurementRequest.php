<?php

namespace App\Http\Requests;

class UpdatePatientMeasurementRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'measurement_type_id' => 'required|int|exists:App\Models\MeasurementType,id,deleted_at,NULL',
			'patient_id' => 'required|int|exists:App\Models\Patient,id|exists:App\Models\User,id,deleted_at,NULL',
			'value' => 'sometimes|numeric',
		];
	}

	public function validationData()
	{
		return array_merge($this->all(), $this->route()->parameters());
	}
}
