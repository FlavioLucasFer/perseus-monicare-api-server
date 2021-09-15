<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthcareProfessionalRequest;
use App\Http\Requests\UpdateHealthcareProfessionalRequest;
use App\Models\HealthcareProfessional;
use App\Models\User;
use Illuminate\Http\Request;
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
			$healthcareProfessionals = HealthcareProfessional::has('user')->get();

			if (!$healthcareProfessionals) 
				return $this->notFound('Healthcare professionals');
		
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

			$user = new User();
			$healthcareProfessional = new HealthcareProfessional();

			$user->name = $validated['name'];
			$user->login = $validated['login'];
			$user->password = $validated['password'];
			$user->cpf = $validated['cpf'];
			$user->phone = $validated['phone'];
			$user->type = 'HP';

			$user->save();

			$healthcareProfessional->id = $user->id;
			$healthcareProfessional->email = $validated['email'];

			$healthcareProfessional->save();

			$healthcareProfessional->user = $user;

			DB::commit();

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
			$healthcareProfessional = HealthcareProfessional::has('user')->find($id);

			if (!$healthcareProfessional) 
				return $this->notFound('Healthcare professional');

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


			$healthcareProfessional = HealthcareProfessional::has('user')->find($id);
			
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
			$healthcareProfessional = HealthcareProfessional::has('user')->find($id);

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
