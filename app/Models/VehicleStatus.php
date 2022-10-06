<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    use HasFactory;


    const ACTIVE = 1;
    const INACTIVE = 2;
    const MAINTENANCE = 3;
    protected $fillable = [
        'name'
    ];
}
