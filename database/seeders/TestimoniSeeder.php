<?php

namespace Database\Seeders;

use App\Models\Testimoni;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < $faker->randomNumber(2, true); $i++) {
            $data = new Testimoni();
            $data->no_urut = $i;
            $data->nama = $faker->name();
            $data->rating = $faker->numberBetween(1, 5);
            $data->konten = $faker->text();
            $data->status = $faker->numberBetween(1,2);
            $data->save();
        }
    }
}
