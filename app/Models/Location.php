<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory,Uuid;
    protected $keyType = 'string';

//    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'status_id'
    ];
    protected $hidden = [
        'id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
