<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Xerox', 'price' => 1, 'is_default' => 1],
            ['name' => 'Xerox (Color)', 'price' => 5, 'is_default' => 1],
            ['name' => 'Printout (B&W)', 'price' => 3, 'is_default' => 1],
            ['name' => 'Printout (Color)', 'price' => 15, 'is_default' => 1],
            ['name' => 'Scan', 'price' => 5, 'is_default' => 1],
            ['name' => 'Lamination', 'price' => 20, 'is_default' => 1],
            ['name' => 'Aadhaar Service', 'price' => 50, 'is_default' => 1],
            ['name' => 'PAN Card Service', 'price' => 110, 'is_default' => 1],
            ['name' => 'Income Certificate', 'price' => 60, 'is_default' => 1],
            ['name' => 'Community Certificate', 'price' => 60, 'is_default' => 1],
        ];

        foreach ($services as $service) {
            Service::create([
                'tenant_id' => 1,
                'name'      => $service['name'],
                'price'     => $service['price'],
                'is_default' => $service['is_default']
            ]);
        }
    }
}

