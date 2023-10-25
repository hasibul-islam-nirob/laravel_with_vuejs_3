<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Counter::factory(1)->create();
        // \App\Models\Products::factory(10)->create();
        // \App\Models\Customers::factory(10)->create();
        // \App\Models\Invoice::factory(10)->create();
        \App\Models\InvoiceItem::factory(10)->create();

    }
}
