<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() : JsonResponse
	{
		try {
			$patients = PatientRepository::find();

			return $this->successResponse($patients);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  app\Http\Resquests\StorePatientRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StorePatientRequest $request) : JsonResponse
	{
		try {
			$validated = $request->safe()->only([
				'name', 'login', 'password',
				'cpf', 'phone', 'birthDate',
				'email',
			]);

			DB::beginTransaction();

			$user = User::create([
				'name' => $validated['name'],
				'login' => $validated['login'],
				'password' => $validated['password'],
				'cpf' => $validated['cpf'],
				'phone' => $validated['phone'],
				'type' => 'CG',
			]);

			Patient::create([
				'id' => $user->id,
				'birthDate' => $validated['birthDate'],
				'email' => $validated['email'],
			]);

			DB::commit();

			$patient = PatientRepository::findById($user->id);

			return $this->successResponse(
				$patient,
				$this->statuses()->CREATED,
			);
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		} catch (\Exception $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(int $id) : JsonResponse
	{
		try {
			$patient = PatientRepository::findById($id);

			return $this->successResponse($patient);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  app\Http\Resquests\UpdatePatientRequest  $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePatientRequest $request, int $id) : JsonResponse
	{
		try {
			$validated = $request->safe()->only([
				'name', 'login', 'password',
				'cpf', 'phone', 'birthDate',
				'email',
			]);
			
			$patient = PatientRepository::findById($id);
			
			if (!$patient)
				return $this->notFound('Patient');
			
			DB::beginTransaction();

			if ($this->hasAttribute('name', $validated))
				$patient->user->name = $validated['name'];

			if ($this->hasAttribute('login', $validated))
				$patient->user->login = $validated['login'];

			if ($this->hasAttribute('password', $validated))
				$patient->user->password = $validated['password'];

			if ($this->hasAttribute('cpf', $validated))
				$patient->user->cpf = $validated['cpf'];

			if ($this->hasAttribute('phone', $validated))
				$patient->user->phone = $validated['phone'];
			
			if ($this->hasAttribute('birthDate', $validated))
				$patient->birthDate = $validated['birthDate'];

			if ($this->hasAttribute('email', $validated))
				$patient->email = $validated['email'];

			$patient->push();

			DB::commit();

			$patient = PatientRepository::findById($id);

			return $this->successResponse($patient);
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		} catch (\Exception $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(int $id) : JsonResponse
	{
		try {
			$patient = PatientRepository::findById($id);

			if (!$patient)
				return $this->notFound('Patient');

			DB::beginTransaction();

			$patient->user->delete();
			$patient->push();

			DB::commit();

			return $this->successResponse();
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		}
	}
}
