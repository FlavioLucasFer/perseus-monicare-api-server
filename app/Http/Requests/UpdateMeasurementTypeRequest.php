<?php

namespace App\Http\Requests;

use App\Rules\Double;

class UpdateMeasurementTypeRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'sometimes|string|max:100|unique:App\Models\MeasurementType',
			'optimum' => ['sometimes', new Double],
			'highest' => ['sometimes', new Double],
			'lowest' => ['sometimes', new Double],
			'maxBorder' => ['sometimes', new Double],
			'minBorder' => ['sometimes', new Double],
		];
	}
}
