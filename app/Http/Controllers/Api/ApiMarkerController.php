<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiMarkerController extends Controller
{
    public string $guard = 'api';
    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function marker(Request $request): JsonResponse
    {
        $validators = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'latitude' => 'numeric|required',
            'longitude' => 'numeric|required',
        ]);
        $errors = $validators->errors();
        $err = [
            'booking_id' => $errors->first('booking_id'),
            'latitude' => $errors->first('latitude'),
            'longitude' => $errors->first('longitude'),
        ];
        if ($validators->fails()){
            return response()->json(['errors' => $err], 422);
        }
        $marker = new Marker;
        $marker->booking_id = $request->input('booking_id');
        $marker->latitude = $request->input('latitude');
        $marker->longitude = $request->input('longitude');
        $marker->save();
        return response()->json(['errors' => $err, 'markers'=>$request->all()], 201);
    }
}
