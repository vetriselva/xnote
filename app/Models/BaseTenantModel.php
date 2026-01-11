<?php
namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

abstract class BaseTenantModel extends Model
{
    protected static function booted()
    {
        if (auth()->check()) {
            static::addGlobalScope(new TenantScope);

            static::creating(function ($model) {
                if (auth()->check() && empty($model->tenant_id)) {
                    $model->tenant_id = auth()->user()->tenant_id;
                }
            });
        }


    }
}

