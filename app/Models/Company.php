<?php

namespace App\Models;

use App\Models\CompanyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'company_type_id',
        'company_size',
        'phone',
        'email',
        'total_rating',
        'street_name',
        'ward_id',
        'district_id',
        'province_id',
        'description',
        'representative_id',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class, 'company_type_id');
    }

    public function representative()
    {
        return $this->belongsTo(User::class, 'representative_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
