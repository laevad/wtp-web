<?php

namespace App\Models;

use Carbon\Carbon;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory,Uuid;
    protected $keyType = 'string';

    const  YET_TO_START = 1;
    const  COMPLETE = 2;
    const  ON_GOING = 3;
    const  CANCELLED = 4;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'driver_id',
        't_trip_start',
        't_trip_end',
        'trip_status_id',
        'trip_start_date',
        'trip_end_date',
        't_total_distance',
        'created_at',
        'from_latitude',
        'from_longitude',
        'to_latitude',
        'to_longitude',

    ];

    protected $casts = [
        'trip_start_date' => 'datetime',
        'trip_end_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function getStatusTypeBadgeAttribute(){
        $badges = [
            self::YET_TO_START=>'warning',
            self::COMPLETE=>'success',
            self::ON_GOING=>'primary',
            self::CANCELLED=>'danger',
        ];
        return $badges[$this->trip_status_id];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
    public function driver(){
        return $this->hasOne(User::class, 'id', 'driver_id');
    }

    public function status(){
        return $this->hasOne(TripStatus::class, 'id', 'trip_status_id');
    }

    public function getTripStartDateAttribute($value){
        return Carbon::parse($value)->toFormattedDate();
    }
    public function getTripEndDateAttribute($value){
        return Carbon::parse($value)->toFormattedDate();
    }
    public function getDateAttribute($value){
        return Carbon::parse($value)->toFormattedDate();
    }
    public function getCreateAtAttribute($value){
        return Carbon::parse($value)->toFormattedDate();
    }

}
