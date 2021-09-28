<?php

namespace App\Http\Controllers;

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
			$healthcareProfessional = new HealthcareProfessional();

			$user->name = $request->name;
			$user->login = $request->login;
			$user->password = $request->password;
			$user->cpf = $request->cpf;
			$user->phone = $request->phone;
			$user->type = 'HP';

			$user->save();

			$healthcareProfessional->id = $user->id;
			$healthcareProfessional->email = $request->email;

			$healthcareProfessional->save();

			$healthcareProfessional->user = $user;

			DB::commit();

			return $this->successResponse(
				$healthcareProfessional,
				$this->statuses()->CREATED,
			);
		} catch (\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse(
				$e->getCode(),
				$e->errorInfo[2],
				$e->getMessage(),
			);
		} catch(\Exception $e) {
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
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, int $id)
	{
		try {
			$healthcareProfessional = HealthcareProfessional::has('user')->find($id);
			
			if (!$healthcareProfessional) 
				return $this->notFound('Healthcare professional');

			DB::beginTransaction();
			
			if (!$healthcareProfessional) {
				return $this->failureResponse(
					404, 
					'Healthcare professinal not found',
					'Healthcare professinal not found',
				);
			}

			$healthcareProfessional->user->name = $request->name;
			$healthcareProfessional->user->login = $request->login;
			$healthcareProfessional->user->password = $request->password;
			$healthcareProfessional->user->cpf = $request->cpf;
			$healthcareProfessional->user->phone = $request->phone;

			$healthcareProfessional->email = $request->email;

			$healthcareProfessional->push();

			DB::commit();

			return $this->successResponse($healthcareProfessional);
		} catch(\PDOException $e) {
			DB::rollBack();

			return $this->failureResponse(
				$e->getCode(), 
				$e->errorInfo[2],
				$e->getMessage(),
			);
		} catch(\Exception $e) {
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

			return $this->failureResponse(
				$e->getCode(),
				$e->errorInfo[2],
				$e->getMessage(),
			);
		}
	}
}
