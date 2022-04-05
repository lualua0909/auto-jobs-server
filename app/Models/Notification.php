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
        'param_1',
        'param_2',
        'user_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function template()
    {
        return $this->belongsTo(NotificationTemplate::class, "template_id");
    }
}
