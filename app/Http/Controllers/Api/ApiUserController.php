<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Rules\MatchOldPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ApiUserController extends Controller
{
    public  $guard = 'api';
    public function __construct()
    {
        $this->middleware('api.auth');
    }
    public function updateProfile(Request $request): JsonResponse
    {
        $validators = Validator::make($request->all(), [
            'name'=> 'sometimes|min:2|nullable',
            'image'=> 'sometimes|nullable|image|mimes:jpg,png,jpeg|max:2048',
            'email' => 'sometimes|email|unique:users,email,'.auth($this->guard)->user()->id,
            'current_password' => ['sometimes', 'required_with:new_password', 'string', new MatchOldPassword],
            'new_password' =>['sometimes','required_with:current_password', 'nullable', 'string','same:password_confirmation',Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),],
            'password_confirmation' => ['sometimes', 'nullable',  'same:new_password'],
        ]);
        $errors = $validators->errors();
        $err = [
            'name' => $errors->first('name'),
            'email' => $errors->first('email'),
            'image' => $errors->first('avatar'),
            'current_password' => $errors->first('current_password'),
            'new_password' => $errors->first('new_password'),
            'password_confirmation' => $errors->first('password_confirmation'),
        ];
        if ($validators->fails()){
            return response()->json([
                'errors' => $err
            ], 422);
        }
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->has('image')){
            $previousPath = auth()->user()->avatar;
            $path = $request->file('image');
            auth()->user()->update(['avatar'=>$path]);
            if ($previousPath !=null){
                Storage::disk('avatars')->delete($previousPath);
            }
        }
        if($request->has('new_password') && $request->filled('new_password')){
            $user->password = Hash::make($request->input('new_password'));
        }
        $user->update();
        return response()->json([
            'errors' => $err
        ]);

    }

    public function addLocation(Request $request){
        $validators = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'latitude' => 'numeric|required',
            'longitude' => 'numeric|required',
        ]);
        $errors = $validators->errors();
        $err = [
            'user_id' => $errors->first('user_id'),
            'latitude' => $errors->first('latitude'),
            'longitude' => $errors->first('longitude'),
        ];
        if ($validators->fails()){
            return response()->json([
                'errors' => $err
            ], 422);
        }

        $loc = new Location;
        $loc->user_id = $request->input('user_id');
        $loc->latitude = $request->input('latitude');
        $loc->longitude = $request->input('longitude');
        $loc->save();

        return response()->json(['message'=>'success!', 'errors'=>$err, 'location'=>$loc], 201);
    }

}
