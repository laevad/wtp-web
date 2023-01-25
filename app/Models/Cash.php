<?php

namespace App\Models;

use Carbon\Carbon;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory, uuid;
    protected $keyType = 'string';
    const CASH_EXPENSE = 1;
    const CASH_INCENTIVE = 2;


    protected $fillable = [

        'expense_type_id',
        'vehicle_id',
        'amount',
        'date',
        'note',
        'cash_type_id',
        'booking_id',
        'is_accepted',
    ];
    protected $casts = [
        'date' => 'datetime',
    ];

    public function getCashTypeBadgeAttribute(): string
    {
        $badges = [
            self::CASH_EXPENSE=>'primary',
            self::CASH_INCENTIVE=>'success'
        ];
        return $badges[$this->cash_type_id];
    }

    public function getDateAttribute($value){
        return Carbon::parse($value)->toFormattedDate();
    }
    public function booking(){
        return $this->hasOne(Booking::class,'id', 'booking_id');
    }
    public function ctype(){
        return $this->hasOne(CashType::class, 'id', 'cash_type_id');
    }
    public function expenseType(){
        return $this->hasOne(ExpenseType::class, 'id', 'expense_type_id');
    }
}
