<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class Request extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() : bool
	{
		return true;
	}

	/**
	 * Custom messages for validations
	 * 
	 * @return array
	 */
	public function messages() : array
	{
		return [
			'cpf' => 'The :attribute must be a valid CPF',
			'formato_cpf' => 'The :attribute must be a valid CPF format',
			'celular_com_ddd' => 'The :attribute must be a valid phone format',
		];
	}

	/**
	 * Throw failure response if validation failed
	 * 
	 * @param \Illuminate\Contracts\Validation\Validator $validator
	 * @return void
	 */
	protected function failedValidation(Validator $validator) : void
	{
		$errors = (new ValidationException($validator))->errors();

		throw new HttpResponseException(
			response()
				->json([
					'success' => false,
					'status' => 422,
					'errors' => $errors,
				]),
		);
	}
}
