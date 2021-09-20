<?php

namespace App\Http\Requests;

class StoreMeasurementTypeRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required|string|max:100|unique:App\Models\MeasurementType',
		];
	}
}
