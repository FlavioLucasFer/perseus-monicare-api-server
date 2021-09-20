<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class apiProtectedRoute extends BaseMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		try {
			JWTAuth::parseToken()->authenticate();
		} catch (Exception $exception) {
			if ($exception instanceof TokenInvalidException)
				return $this->failureResponse('Token is invalid');

			else if ($exception instanceof TokenExpiredException) 
				return $this->failureResponse('Token is expired');
			
			else 
				return $this->failureResponse('Authorization token not found');
		}
		
		return $next($request);
	}

	/**
	 * Anauthorized failure response
	 * 
	 * @param  string $message
	 * @return \Illuminate\Http\JsonResponse
	 */
	private function failureResponse(string $message) : JsonResponse
	{
		return new JsonResponse([
			'success' => false,
			'status' => 401,
			'errors' => $message,
		], 401);
	}
}
