<?php

namespace App\Events;

use App\Models\Tenant;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SeederEvent
{
    use Dispatchable, SerializesModels;
    public $tenant;
    /**
     * Create a new event instance.
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }
}
