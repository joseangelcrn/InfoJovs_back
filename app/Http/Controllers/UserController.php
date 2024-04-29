<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HidesAttributes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     *
     * @OA\Info(
     *      version="1.0.0",
     *      title="L5 OpenApi",
     *      description="L5 Swagger OpenApi for the InfoJovs backend. "
     * )
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Users"},
     *     description="Sign up in InfoJovs",
     *
     *      @OA\Parameter(
     *      name="name",
     *      description="Real name of user",
     *      example="José Ángel",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *     @OA\Parameter(
     *      name="first_surname",
     *      description="First surname of user",
     *      example="Cabeza",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *
     *     @OA\Parameter(
     *      name="second_surname",
     *      description="Second surname of user",
     *      example="Rodríguez-Navas",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *
     *     @OA\Parameter(
     *      name="email",
     *      description="Email of user",
     *      example="jose@gmail.com",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *
     *     @OA\Parameter(
     *      name="password",
     *      description="Password of user",
     *      example="josejose",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Some error in the request")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Users"},
     *     description="Login to InfoJovs",
     *
     *      @OA\Parameter(
     *      name="email",
     *      description="Email of user",
     *      example="jose@gmail.com",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *      @OA\Parameter(
     *      name="password",
     *      description="Password of user",
     *      example="josejose",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *     @OA\Response(response=200, description="Successful operation, you will get the token to visit protected routes in InfoJovs"),
     *     @OA\Response(response=400, description="Some error in the request")
     * )
     */
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

    /**
     * @SWG\Post(
     *     path="/logout",
     *     summary="Close a user session",
     *     tags={"Users"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Some error in the request")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/user/info",
     *     summary="Information about logged user",
     *     tags={"Users"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Some error in the request")
     * )
     */
    public function info(Request $request)
    {
        $user = $request->user()->load(['roles' => function ($q) {
            $q->select('name');
        }]);

        return response()->json(['user' => $user]);
    }


}
