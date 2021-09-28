<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Kinship implements Rule
{
	private $mother = 'MT';
	private $father = 'FT';
	private $custodian = 'CT';
	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		return $value === $this->mother || $value === $this->father || $value === $this->custodian;
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
			return "The :attribute must be one of: {$this->mother} (Mother), {$this->father} (Father) or {$this->custodian} (Custodian)";
	}
}
