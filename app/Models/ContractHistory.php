<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractHistory extends Model
{
    use HasFactory;

    protected $table = 'contract_history';

    protected $fillable = ['contract_id', 'status', 'created_at', 'updated_at'];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function status_label()
    {
        return $this->belongsTo(ContractStatus::class, 'status', 'id');
    }
}
