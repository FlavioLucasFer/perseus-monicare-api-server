<?php

namespace App\Http\Requests;

use App\Rules\AlphaWithWhiteSpace;
use Illuminate\Validation\Rules\Password;

class StoreDoctorRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => ['required', new AlphaWithWhiteSpace],
			'login' => 'required|string|max:150|unique:App\Models\User',
			'password' => ['required', 'max:255', Password::defaults()],
			'cpf' => 'required|cpf|formato_cpf|max:14|unique:App\Models\User',
			'phone' => 'required|celular_com_ddd|max:15',
			'crm' => 'required|string|max:13|unique:App\Models\Doctor',
			'specialty' => 'required|string|max:50',
			'email' => 'required|email|max:255',
		];
	}
}
