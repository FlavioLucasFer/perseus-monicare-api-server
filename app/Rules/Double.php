<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Double implements Rule
{
	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		return is_double($value);
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return 'The :attribute must be of type double';
	}
}
