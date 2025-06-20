<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $bank = new Bank();
        $bank->queue = 1;
        $bank->name = "PT JGU";
        $bank->bank = "BCA";
        $bank->bank_number = "12012234236400";
        $bank->status = 1;
        $bank->save();

        $bank = new Bank();
        $bank->queue = 1;
        $bank->name = "CV JGU";
        $bank->bank = "BNI";
        $bank->bank_number = "12012234236400";
        $bank->status = 1;
        $bank->save();
    }
}
