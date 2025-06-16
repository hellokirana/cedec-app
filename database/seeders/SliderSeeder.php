<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < $faker->randomNumber(1, true); $i++) {
            $data = new Slider();
            $data->no_urut = $i;
            $data->title = $faker->sentence();
            $data->link = '#';
            $data->status = 1;
            $data->save();
        }
        //
    }
}
