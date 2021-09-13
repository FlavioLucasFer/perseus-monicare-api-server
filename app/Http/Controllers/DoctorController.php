<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
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
			$doctors = Doctor::has('user')->get();

			if (!$doctors)
				return $this->notFound('Doctors');

			return $this->successResponse($doctors);
		} catch (\PDOException $e) {
			return $this->failureResponse(
				$e->getCode(),
				$e->errorInfo[2],
				$e->getMessage(),
			);
		}	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		try {
			DB::beginTransaction();

			$user = new User();
			$doctor = new Doctor();

			$user->name = $request->name;
			$user->login = $request->login;
			$user->password = $request->password;
			$user->cpf = $request->cpf;
			$user->phone = $request->phone;
			$user->type = 'DC';

			$user->save();

			$doctor->id = $user->id;
			$doctor->crm = $request->crm;
			$doctor->specialty = $request->specialty;
			$doctor->email = $request->email;

			$doctor->save();

			$doctor->user = $user;

			DB::commit();

			return $this->successResponse(
				$doctor,
				$this->statuses()->CREATED,
			);
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse(
				$e->getCode(),
				$e->errorInfo[2],
				$e->getMessage(),
			);
		} catch (\Exception $e) {
			DB::rollBack();

			return $this->failureResponse(
				$e->getCode(),
				$e->getMessage(),
				$e->getMessage(),
			);
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
			$doctor = Doctor::has('user')->find($id);

			if (!$doctor)
				return $this->notFound('Doctor');

			return $this->successResponse($doctor);
		} catch (\PDOException $e) {
			return $this->failureResponse(
				$e->getCode(),
				$e->errorInfo[2],
				$e->getMessage(),
			);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, int $id)
	{
		try {
			DB::beginTransaction();

			$doctor = Doctor::has('user')->find($id);

			if (!$doctor) 
				$this->notFound('Doctor');

			$doctor->user->name = $request->name;
			$doctor->user->login = $request->login;
			$doctor->user->password = $request->password;
			$doctor->user->cpf = $request->cpf;
			$doctor->user->phone = $request->phone;

			$doctor->email = $request->email;

			$doctor->push();

			DB::commit();

			return $this->successResponse($doctor);
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse(
				$e->getCode(),
				$e->errorInfo[2],
				$e->getMessage(),
			);
		} catch (\Exception $e) {
			DB::rollBack();

			return $this->failureResponse(
				$e->getCode(),
				$e->getMessage(),
				$e->getMessage(),
			);
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
			$doctor = Doctor::has('user')->find($id);

			if (!$doctor)
				return $this->notFound('Healthcare professional');

			DB::beginTransaction();

			$doctor->user->delete();

			$doctor->push();

			DB::commit();

			return $this->successResponse();
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse(
				$e->getCode(),
				$e->errorInfo[2],
				$e->getMessage(),
			);
		}
	}
}
