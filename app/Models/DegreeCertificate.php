<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
