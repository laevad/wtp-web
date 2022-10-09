<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public  $guard = 'api';
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['login']]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        $validators = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);
        if ($validators->fails()){
            $errors = $validators->errors();
            $err = [
                'email' => $errors->first('email'),
                'password' => $errors->first('password'),
            ];
            return response()->json([
                'errors' => $err
            ], 422);
        }

        else if (! $token = auth($this->guard)->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        if (auth($this->guard)->user()->role_id != User::ROLE_DRIVER){
            return response()->json(['error' => 'Only Driver Can login'], 422);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth($this->guard)->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth($this->guard)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth($this->guard)->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60,
            'id' =>auth($this->guard)->user()->id,
        ]);
    }
}
