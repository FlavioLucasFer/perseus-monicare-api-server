<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthcareProfessionalRequest;
use App\Http\Requests\UpdateHealthcareProfessionalRequest;
use App\Models\HealthcareProfessional;
use App\Models\User;
use App\Repositories\HealthcareProfessionalRepository;
use Illuminate\Support\Facades\DB;

class HealthcareProfessionalController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$healthcareProfessionals = HealthcareProfessionalRepository::find();
		
			return $this->successResponse($healthcareProfessionals);
		} catch(\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreHealthcareProfessionalRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreHealthcareProfessionalRequest $request)
	{
		try {
			$validated = $request->safe()->only([
				'name', 'login', 'password',
				'cpf', 'phone', 'email',
			]);

			DB::beginTransaction();

			$user = User::create([
				'name' => $validated['name'],
				'login' => $validated['login'],
				'password' => $validated['password'],
				'cpf' => $validated['cpf'],
				'phone' => $validated['phone'],
				'type' => 'HP',
			]);

			HealthcareProfessional::create([
				'id' => $user->id,
				'email' => $validated['email'],
			]);

			DB::commit();

			$healthcareProfessional = HealthcareProfessionalRepository::findById($user->id);

			return $this->successResponse(
				$healthcareProfessional,
				$this->statuses()->CREATED,
			);
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		} catch(\Exception $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(int $id)
	{
		try {
			$healthcareProfessional = HealthcareProfessionalRepository::findById($id);

			return $this->successResponse($healthcareProfessional);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateHealthcareProfessionalRequest  $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateHealthcareProfessionalRequest $request, int $id)
	{
		try {
			$validated = $request->safe()->only([
				'name', 'login', 'password',
				'cpf', 'phone', 'email',
			]);

			$healthcareProfessional = HealthcareProfessionalRepository::findById($id);
			
			if (!$healthcareProfessional) 
				return $this->notFound('Healthcare professional');

			DB::beginTransaction();
			
			if ($this->hasAttribute('name', $validated))
				$healthcareProfessional->user->name = $validated['name'];

			if ($this->hasAttribute('login', $validated))
				$healthcareProfessional->user->login = $validated['login'];

			if ($this->hasAttribute('password', $validated))
				$healthcareProfessional->user->password = $validated['password'];

			if ($this->hasAttribute('cpf', $validated))
				$healthcareProfessional->user->cpf = $validated['cpf'];

			if ($this->hasAttribute('phone', $validated))
				$healthcareProfessional->user->phone = $validated['phone'];
			
			if ($this->hasAttribute('email', $validated))
				$healthcareProfessional->email = $validated['email'];

			$healthcareProfessional->push();

			DB::commit();

			$healthcareProfessional = HealthcareProfessionalRepository::findById($id);

			return $this->successResponse($healthcareProfessional);
		} catch(\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		} catch(\Exception $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(int $id)
	{
		try {
			$healthcareProfessional = HealthcareProfessionalRepository::findById($id);

			if (!$healthcareProfessional)
				return $this->notFound('Healthcare professional');

			DB::beginTransaction();

			$healthcareProfessional->user->delete();
			$healthcareProfessional->push();

			DB::commit();

			return $this->successResponse();
		} catch(\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		}
	}
}
