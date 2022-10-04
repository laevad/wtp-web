<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiIncentiveController extends Controller
{
    public string $guard = 'api';
    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function incentive(): JsonResponse
    {
        $incentives = Cash::query()->where('cash_type_id', '=', Cash::CASH_INCENTIVE)->latest()->paginate(5);
        return response()->json($incentives);
    }
}
