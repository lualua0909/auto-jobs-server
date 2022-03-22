<?php

namespace App\Models;

use App\Models\NotificationTemplate;
use App\Models\Job;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'job_id',
        'company_id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function template()
    {
        return $this->belongsTo(NotificationTemplate::class, "template_id");
    }

    public function job()
    {
        return $this->belongsTo(Job::class, "job_id");
    }

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id");
    }
}
