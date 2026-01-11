<?php

namespace Database\Seeders;

use App\Events\SeederEvent;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tenant = Tenant::create(['name'=> 'Vnote']);
        event(new SeederEvent($tenant));
        User::factory()->create([
            'tenant_id' => $tenant->id,
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin@123'
        ]);

    }
}
