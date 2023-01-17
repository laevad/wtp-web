<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Incentise extends Model
{
    use HasFactory, Uuid;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'amount',
    ];

    /*hide create update*/
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
