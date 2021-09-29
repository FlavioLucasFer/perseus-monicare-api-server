<?php

namespace App\Http\Requests;

use App\Rules\Double;

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
			'optimum' => ['required', new Double],
			'highest' => ['required', new Double],
			'lowest' => ['required', new Double],
			'maxBorder' => ['required', new Double],
			'minBorder' => ['required', new Double],
		];
	}
}
