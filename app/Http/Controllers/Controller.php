<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Server status codes
	 * 
	 * @return JSON
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
			'INTERNAL_ERROR' => 500,
		]));
	}

	/**
	 * Success response
	 * 
	 * @param  int $status=200
	 * @return \Illuminate\Http\Response
	 */
	protected function successResponse($data=null, int $status=200)
	{
		return response()
			->json([
				'success' => true,
				'data' => $data ? $data : json_decode('{}'),
			], $status);
	}

	/**
	 * Failure response
	 * 
	 * @param  mixed $code
	 * @param  string $message
	 * @param  string $error
	 * @param  int $status=400
	 * @return \Illuminate\Http\Response
	 */
	protected function failureResponse($code, string $message, string $error, int $status=400)
	{
		return response()
			->json([
				'success' => false,
				'data' => [
					'code' => $code,
					'message' => $message,
					'error' => $error,
				],
			], $status);
	}

	/**
	 * Resource not found failure response
	 * 
	 * @param string $resource
	 * @return \Illuminate\Http\Response
	 */
	protected function notFound(string $resource)
	{
		return $this->failureResponse(
			$this->statuses()->NOT_FOUND,
			"$resource not found",
			"$resource not found",
		);
	}
}
