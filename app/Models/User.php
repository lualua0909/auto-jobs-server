<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'password',
        'street_name',
        'ward_id',
        'district_id',
        'province_id',
        'created_by'];

    protected $guarded = ['id'];

    protected $hidden = ['password']; // bỏ password ra khỏi response
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->select(['id', 'name']);
    }

    public function child_users()
    {
        return $this->hasMany(User::class, 'created_by', 'id')->select(['id', 'name']);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
