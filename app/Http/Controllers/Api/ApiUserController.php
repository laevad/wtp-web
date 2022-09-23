<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiUserController extends Controller
{
    public  $guard = 'api';
    public function __construct()
    {


        $this->middleware('api.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    public function updateProfile(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'name'=> 'sometimes|min:2|nullable',
            'avatar'=> 'sometimes|nullable|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            'email' => 'sometimes|unique:users,email,'.auth($this->guard)->user()->id,
            'current_password' => ['sometimes', 'nullable', 'required_with:new_password', 'string', new MatchOldPassword],
            'new_password' =>['sometimes', 'nullable', 'string','confirmed',Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),],
        ]);
        if ($validators->fails()){
            $errors = $validators->errors();
            $err = [
                'name' => $errors->first('name'),
                'email' => $errors->first('email'),
                'avatar' => $errors->first('avatar'),
                'current_password' => $errors->first('current_password'),
                'new_password' => $errors->first('new_password'),
            ];
            return response()->json([
                'errors' => $err
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
