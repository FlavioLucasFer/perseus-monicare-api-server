<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaWithWhiteSpace implements Rule
{
	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value) : bool
	{
		return preg_match('/^[a-zA-ZÀ-ú\s]*$/', $value);
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() : string
	{
		return 'The :attribute must only contain letters and white spaces';
	}
}
