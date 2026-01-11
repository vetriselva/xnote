<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends BaseTenantModel
{
    protected $fillable = ['tenant_id','name', 'price', 'is_default'];
}

