<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'first_surname' => 'required|max:255',
            'second_surname' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->messages(),
            ], 400);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $newUser = User::create($data);

        return response()->json(['message' => 'User created successfully']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()->messages(),
            ], 400);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Wrong credentials'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('auth_token');

        return response()->json([
            'token' => $tokenResult->accessToken,
            'message' => 'Login successfully',
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function info(Request $request)
    {
        $user = $request->user();

        return response()->json(['message' => $user]);
    }


}
