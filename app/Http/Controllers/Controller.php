<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function statuses()
	{
		return json_decode(json_encode([
			'OK' => 200,
			'CREATED' => 201,
			'BAD_REQUEST' => 400,
			'ANAUTHORIZED' => 401,
			'FORBIDDEN' => 403,
			'INTERNAL_ERROR' => 500,
		]));
	}

	protected function successResponse($data=null, $status=200)
	{
		return response()
			->json([
				'success' => true,
				'data' => $data ? $data : json_decode('{}'),
			], $status);
	}

	protected function failureResponse($code, $message, $error, $status=400)
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
}
