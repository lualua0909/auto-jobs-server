<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employer_id',
        'job_id',
        'status',
        'created_at',
        'updated_at',
        'finished_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function history()
    {
        return $this->hasMany(ContractHistory::class, 'contract_id', 'id');
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id', 'id');
    }

    public function contract_status()
    {
        return $this->belongsTo(ContractStatus::class, 'status', 'id');
    }    
}
