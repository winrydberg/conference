<?php

namespace Database\Seeders;

use App\Models\PaymentMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMode::create([
            'name' => 'Bank Account Payment / Deposit',
            'payurl' => ''
        ]);
        
        PaymentMode::create([
            'name' => 'MOMO Payment',
            'payurl' => ''
        ]);

        PaymentMode::create([
            'name' => 'Onsite Payment',
            'payurl' => ''
        ]);

        
    }
}
