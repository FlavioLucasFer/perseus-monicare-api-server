<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Server status codes
	 * 
	 * @return mixed
	 */
	protected function statuses() 
	{
		return json_decode(json_encode([
			'OK' => 200,
			'CREATED' => 201,
			'BAD_REQUEST' => 400,
			'ANAUTHORIZED' => 401,
			'FORBIDDEN' => 403,
			'NOT_FOUND' => 404,
			'UNPROCESSABLE_ENTITY' => 422,
			'INTERNAL_ERROR' => 500,
		]));
	}

	/**
	 * Check if array contains the given attribute
	 * 
	 * @param string $attribute
	 * @param array $array
	 * @return bool
	 */
	protected function hasAttribute(string $attribute, array $array) : bool
	{
		return array_key_exists($attribute, $array);
	}

	/**
	 * Success response
	 * 
	 * @param  int $status=200
	 * @return \Illuminate\Http\Response
	 */
	protected function successResponse($data=null, int $status=200) : JsonResponse
	{
		return new JsonResponse([
			'success' => true,
			'status' => $status,
			'data' => $data ? $data : json_decode('{}'),
		], $status);
	}

	/**
	 * Failure response
	 * 
	 * @param  $errors
	 * @param  int $status=400
	 * @return \Illuminate\Http\Response
	 */
	protected function failureResponse($errors, int $status=400) : JsonResponse
	{
		return new JsonResponse([
			'success' => false,
			'status' => $status,
			'errors' => $errors,
		], $status);
	} 

	/**
	 * Resource not found failure response
	 * 
	 * @param string $resource
	 * @return \Illuminate\Http\Response
	 */
	protected function notFound(string $resource) : JsonResponse
	{
		return $this->failureResponse(
			"$resource not found",
			$this->statuses()->NOT_FOUND,
		);
	}
}
