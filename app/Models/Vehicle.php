<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Vehicle extends Model
{
    use HasFactory,Uuid;
    protected $keyType = 'string';

    protected $fillable = [
        'registration_number',
        'name',
        'model',
        'chassis_no',
        'engine_no',
        'manufactured_by',
        'registration_expiry_date',
        'status'
    ];

    protected $casts = [
        'registration_expiry_date' => 'datetime'
    ];


    public function getRegistrationExpiryDateAttribute($value){
        return Carbon::parse($value)->toFormattedDate();
    }
}
