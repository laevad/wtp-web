<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    const  API_ID = '3208558c-4344-3f9f-9330-0513c25f77c4';
    protected $fillable = [
        'name'
    ];
}
