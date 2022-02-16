<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaregiverRequest;
use App\Http\Requests\UpdateCaregiverRequest;
use App\Models\Caregiver;
use App\Models\User;
use App\Repositories\CaregiverRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CaregiverController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() : JsonResponse
	{
		try {
			$caregivers = CaregiverRepository::find();

			return $this->successResponse($caregivers);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreCaregiverRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreCaregiverRequest $request) : JsonResponse
	{
		try {
			$validated = $request->safe()->only([
				'name', 'login', 'password',
				'cpf', 'phone', 'birthDate',
				'kinship', 'email', 'patientId',
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

			Caregiver::create([
				'id' => $user->id,
				'birthDate' => $validated['birthDate'],
				'kinship' => $validated['kinship'],
				'email' => $validated['email'],
				'patientId' => $validated['patientId'],
			]);

			DB::commit();

			$caregiver = CaregiverRepository::findById($user->id);

			return $this->successResponse($caregiver, $this->statuses()->CREATED);
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
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(int $id) : JsonResponse
	{
		try {
			$caregiver = CaregiverRepository::findById($id);

			return $this->successResponse($caregiver);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateCaregiverRequest  $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateCaregiverRequest $request, int $id) : JsonResponse
	{
		try {
			$validated = $request->safe()->only([
				'name', 'login', 'password',
				'cpf', 'phone', 'birthDate',
				'kinship', 'email', 'patientId',
			]);

			$caregiver = CaregiverRepository::findById($id);

			if (!$caregiver)
				return $this->notFound('Caregiver');

			DB::beginTransaction();

			if ($this->hasAttribute('name', $validated))
				$caregiver->user->name = $validated['name'];

			if ($this->hasAttribute('login', $validated))
				$caregiver->user->login = $validated['login'];

			if ($this->hasAttribute('password', $validated))
				$caregiver->user->password = $validated['password'];

			if ($this->hasAttribute('cpf', $validated))
				$caregiver->user->cpf = $validated['cpf'];

			if ($this->hasAttribute('phone', $validated))
				$caregiver->user->phone = $validated['phone'];

			if ($this->hasAttribute('birthDate', $validated))
				$caregiver->birthDate = $validated['birthDate'];

			if ($this->hasAttribute('kinship', $validated))
				$caregiver->kinship = $validated['kinship'];

			if ($this->hasAttribute('email', $validated))
				$caregiver->email = $validated['email'];

			if ($this->hasAttribute('patientId', $validated))
				$caregiver->patientId = $validated['patientId'];
				
			$caregiver->push();

			DB::commit();

			$caregiver = CaregiverRepository::findById($id);

			return $this->successResponse($caregiver);
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
			$caregiver = CaregiverRepository::findById($id);

			if (!$caregiver)
				return $this->notFound('Caregiver');

			DB::beginTransaction();

			$caregiver->user->delete();
			$caregiver->push();

			DB::commit();

			return $this->successResponse();
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		}
	}
}
