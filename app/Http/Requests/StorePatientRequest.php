<?php

namespace App\Http\Requests;

use App\Rules\AlphaWithWhiteSpace;
use Illuminate\Validation\Rules\Password;

class StorePatientRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() : array
	{
		return [
			'name' => ['required', new AlphaWithWhiteSpace],
			'login' => 'required|string|max:150|unique:App\Models\User',
			'password' => ['required', 'max:255', Password::defaults()],
			'cpf' => 'required|cpf|formato_cpf|max:14|unique:App\Models\User',
			'phone' => 'required|celular_com_ddd|max:15',
			'birthDate' => 'required|date',
			'email' => 'present|nullable|email|max:255',
		];
	}
}
