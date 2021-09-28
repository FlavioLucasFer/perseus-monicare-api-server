<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
			$users = User::all();
			// echo $users;
			return response()
				->json($users, 200);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = new User();

			$user->name = $request->name;
			$user->login = $request->login;
			$user->password = $request->password;
			$user->cpf = $request->cpf;
			$user->phone = $request->phone;
			$user->type = $request->type;

			$user->save();

			return response()
				->json([
					'success' => true,
					'user' => $user,
				], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      echo $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
			if (!empty($request->name)) 
				$user->name = $request->name;
			if (!empty($request->email))
				$user->email = $request->email;
			if (!empty($request->password))
				$user->password = $request->password;

			$user->save();

			echo $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
      $user->delete();
    }
}
