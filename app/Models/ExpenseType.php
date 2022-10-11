<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    use HasFactory;

    const MEAL = 1;
    const BARGE_FARE = 2;
    const LABOR_COST = 3;
    const OTHER_EXPENSE = 4;
    protected $fillable = [
        'name'
    ];
}
