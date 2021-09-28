<?php

namespace App\Exceptions;

use Exception;

const cpfExCode      = 1001;
const emailExCode    = 1002;
const userTypeExCode = 1003;
const phoneExCode    = 1004;

class CustomExceptions
{
	public static function invalidCPF()
	{
		throw new Exception('Invalid CPF', cpfExCode);
	}
	
	public static function invalidEmail()
	{
		throw new Exception('Invalid e-mail', emailExCode);
	}
	
	public static function invalidUserType()
	{
		throw new Exception('Invalid user type', userTypeExCode);
	}
	
	public static function invalidPhone()
	{
		throw new Exception('Invalid phone', phoneExCode);
	}
}