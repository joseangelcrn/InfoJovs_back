<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
                "errors" => $validator->errors()->messages(),
            ], 400);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $newUser = User::create($data);

        return response()->json(['message' => 'User created successfully']);
    }


}
