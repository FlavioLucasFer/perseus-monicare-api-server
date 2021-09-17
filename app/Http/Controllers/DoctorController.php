<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\User;
use App\Repositories\DoctorRepository;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		try {
			$doctors = DoctorRepository::find();

			return $this->successResponse($doctors);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreDoctorRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreDoctorRequest $request)
	{
		try {
			$validated = $request->safe()->only([
				'name', 'login', 'password',
				'cpf', 'phone', 'crm',
				'specialty', 'email',
			]);

			DB::beginTransaction();

			$user = User::create([
				'name' => $validated['name'],
				'login' => $validated['login'],
				'password' => $validated['password'],
				'cpf' => $validated['cpf'],
				'phone' => $validated['phone'],
				'type' => 'DC',
			]);

			Doctor::create([
				'id' => $user->id,
				'crm' => $validated['crm'],
				'specialty' => $validated['specialty'],
				'email' => $validated['email'],
			]);

			DB::commit();

			$doctor = DoctorRepository::findById($user->id);

			return $this->successResponse(
				$doctor,
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
	public function show(int $id)
	{
		try {
			$doctor = DoctorRepository::findById($id);

			return $this->successResponse($doctor);
		} catch (\PDOException $e) {
			return $this->failureResponse($e->getMessage());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateDoctorRequest  $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateDoctorRequest $request, int $id)
	{
		try {
			$validated = $request->safe()->only([
				'name', 'login', 'password',
				'cpf', 'phone', 'crm',
				'specialty', 'email',
			]);

			$doctor = DoctorRepository::findById($id);

			if (!$doctor) 
				return $this->notFound('Doctor');

			DB::beginTransaction();

			if ($this->hasAttribute('name', $validated))
				$doctor->user->name = $validated['name'];

			if ($this->hasAttribute('login', $validated))
				$doctor->user->login = $validated['login'];

			if ($this->hasAttribute('password', $validated))
				$doctor->user->password = $validated['password'];

			if ($this->hasAttribute('cpf', $validated))
				$doctor->user->cpf = $validated['cpf'];

			if ($this->hasAttribute('phone', $validated))
				$doctor->user->phone = $validated['phone'];
			
			if ($this->hasAttribute('crm', $validated))
				$doctor->crm = $validated['crm'];

			if ($this->hasAttribute('specialty', $validated))
				$doctor->specialty = $validated['specialty'];

			if ($this->hasAttribute('email', $validated))
				$doctor->email = $validated['email'];

			$doctor->push();

			DB::commit();

			$doctor = DoctorRepository::findById($id);

			return $this->successResponse($doctor);
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
	public function destroy(int $id)
	{
		try {
			$doctor = DoctorRepository::findById($id);

			if (!$doctor)
				return $this->notFound('Doctor');

			DB::beginTransaction();

			$doctor->user->delete();
			$doctor->push();

			DB::commit();

			return $this->successResponse();
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse($e->getMessage());
		}
	}
}
