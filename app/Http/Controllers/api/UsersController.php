<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

//resource
use App\Http\Resources\RegisterResource;
use App\Http\Resources\LoginResource;

//models
use App\Models\User;

class UsersController extends Controller {

	public function register(Request $request) {
		if (!Auth::check()) {
			$validator = Validator::make($request->all(), [
				'name' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|string|min:6',
			]);

			if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()], 422);
			}

			if (User::where('email', $request->email)->exists()) {
				return response()->json(['error' => 'Bu e-posta adresi zaten kullanımda'], 422);
			}

			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password),
			]);
			return new RegisterResource($user);
		}else {
			return recirect('dashboard');
		}
	}

	public function login(Request $request){
		$cs = $request->only('email', 'password');
		if (Auth::attempt($cs)) {
			$user = Auth::user();
			$token = $user->createToken('token')->plainTextToken;
			return (new LoginResource($user))->additional(['token' => $token]);
		} else {
			return response()->json(['error' => 'Unauthorized'], 401);
		}
	}

}
