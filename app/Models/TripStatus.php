<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripStatus extends Model
{
    use HasFactory;

    const YET_TO_START = 1;
    const COMPLETE = 2;
    const ON_GOING = 3;
    const CANCELLED = 4;
    const PENDING = 5;


    protected $fillable = [
        'name'
    ];
}
