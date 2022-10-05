<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    use HasFactory,Uuid;
    protected $keyType = 'string';

    protected $fillable = [
        'booking_id',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
