<?php

namespace App\Models;

class Contact extends BaseTenantModel
{
    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'email',
        'company',
        'address',
        'has_reminder',
        'reminder_at',
        'reminder_note',
    ];

    protected $casts = [
        'reminder_at' => 'datetime',
    ];
}
