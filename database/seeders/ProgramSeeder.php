<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        //
        $data_all = [
            'Teknik Informatika',
            'Teknik Elektro',
            'Teknik Industri',
            'Teknik Sipil',
        ];
        foreach ($data_all as $row => $value) {
            $program = new Program();
            $program->id = Str::uuid();
            $program->title = $value;
            $program->status = 1;
            if ($program->save()) {
                
            }
        }
    }
}