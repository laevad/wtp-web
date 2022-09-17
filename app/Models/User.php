<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Foundation\Auth\User as Authenticatable;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,Uuid;

    const ROLE_ADMIN  = "1";
    const ROLE_USER = "2";
    const ROLE_CLIENT = "3";
    const ROLE_DRIVER = "4";
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'mobile',
        'age',
        'license_number',
        'license_expiry_date',
        'total_experience',
        'date_of_joining',
        'status',
        'address',
        'role_id',
        'number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'license_expiry_date' => 'datetime',
        'date_of_joining' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    /*avatar*/
    protected $appends = [
        'avatar_url',
    ];

    public function getAvatarUrlAttribute(){
        if ($this->avatar && Storage::disk('avatars')->exists($this->avatar)){
            return Storage::disk('avatars')->url($this->avatar);
        }
        return asset('images/noimage.png');
    }

    public function getLicenseExpiryDateAttribute($value){
        return Carbon::parse($value)->toFormattedDate();
    }
    public function getDateOfJoiningAttribute($value){
        return Carbon::parse($value)->toFormattedDate();
    }

    public function isAdmin(){
        if ($this->role->role != self::ROLE_ADMIN){
            return false;
        }else{
            return true;
        }
    }
    public function isClient(){
        if ($this->role->role != self::ROLE_CLIENT){
            return false;
        }else{
            return true;
        }
    }
}
