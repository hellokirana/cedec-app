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
        $bank->no_urut = 1;
        $bank->nama = "PT Jaya Maju";
        $bank->bank = "BCA";
        $bank->no_rekening = "12012234236400";
        $bank->status = 1;
        $bank->save();

        $bank = new Bank();
        $bank->no_urut = 1;
        $bank->nama = "CV Maju Jaya";
        $bank->bank = "BNI";
        $bank->no_rekening = "12012234236400";
        $bank->status = 1;
        $bank->save();
    }
}
