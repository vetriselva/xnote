<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends BaseTenantModel
{
    protected $fillable = [
        'service_id',
        'description',
        'quantity',
        'unit_price',
        'total_amount',
        'payment_mode',
        'created_at',
        'transaction_date',
    ];

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function setTransactionDateAttribute($value)
    {
        $this->attributes['transaction_date'] = $value ?? now()->toDateString();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}

