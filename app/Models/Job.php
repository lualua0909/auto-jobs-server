<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DegreeCertificate;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'company_id',
        'number_of_workers',
        'description',
        'monthly_salary',
        'hourly_salary',
        'degree_required_id',
        'requirements',
        'benefits',
        'street_name',
        'ward_id',
        'district_id',
        'province_id',
        'start_time',
        'end_time',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
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

    public function degreeRequired()
    {
        return $this->belongsTo(DegreeCertificate::class, 'degree_required_id');
    }
}
