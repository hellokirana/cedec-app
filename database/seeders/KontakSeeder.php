<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class KontakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < $faker->randomNumber(2, true); $i++) {
            $data = new Kontak();
            $data->nama = $faker->name();
            $data->email = $faker->email();
            $data->pesan = $faker->text();
            $data->subjek = $faker->sentence();
            $data->save();
        }
    }
}
