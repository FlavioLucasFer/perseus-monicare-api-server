<?php

namespace App\Http\Controllers;

use App\Repositories\CaregiverRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\HealthcareProfessionalRepository;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	/**
	 * Get a JWT via given credentials.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request) : JsonResponse
	{
		$credentials = $request->only(['login', 'password']);

		if (!$token = auth('api')->attempt($credentials)) {
			return $this->failureResponse('Invalid credentials');
		}

		return $this->respondWithToken($token);
	}

	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout() : JsonResponse
	{
		if (!auth('api')->user())
			return $this->notFound('Authenticated user');
		
		auth('api')->logout();

		return $this->successResponse('Successfully logged out');
	}

	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function me() : JsonResponse
	{
		$user = auth('api')->user();

		if (!$user)
			return $this->notFound('Authenticated user');

		switch ($user->type) {
			case 'AD':
				break;

			case 'PT':
				$user = PatientRepository::findById($user->id);
				break;

			case 'DC':
				$user = DoctorRepository::findById($user->id);
				break;

			case 'CG':
				$user = CaregiverRepository::findById($user->id);
				break;

			case 'HP':
				$user = HealthcareProfessionalRepository::findById($user->id);
				break;

			default:
				return $this->failureResponse('Failed to get logged user');
		}

		return $this->successResponse($user);
	}

	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh() : JsonResponse
	{
		if (!auth('api')->user())
			return $this->notFound('Authenticated user');

		return $this->respondWithToken(auth('api')->refresh());
	}

	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token) : JsonResponse
	{
		return $this->successResponse([
			'accessToken' => $token,
			'tokenType' => 'bearer',
			'expiresIn' => auth('api')->factory()->getTTL() * 60,
		]);
	}
}
