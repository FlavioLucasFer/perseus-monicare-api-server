<?php

namespace App\Http\Requests;

use App\Rules\AlphaWithWhiteSpace;
use Illuminate\Validation\Rules\Password;

class UpdatePatientRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() : array
	{
		return [
			'name' => ['sometimes', new AlphaWithWhiteSpace],
			'login' => 'sometimes|string|max:150|unique:App\Models\User',
			'password' => ['sometimes', 'max:255', Password::defaults()],
			'cpf' => 'sometimes|cpf|formato_cpf|max:14|unique:App\Models\User',
			'phone' => 'sometimes|celular_com_ddd|max:15',
			'birthDate' => 'sometimes|date',
			'email' => 'sometimes|nullable|email|max:255',
		];
	}
}
