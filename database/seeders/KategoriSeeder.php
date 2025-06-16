<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        //
        $data_all = [
            'Kebersihan',
            'Elektronik',
            'Perabotan',
            'Mekanik',
            'Tukang',
            'Tukang Pipa',
            'Dekorasi',
            'Tukang Kayu'
        ];
        foreach ($data_all as $row => $value) {
            $no = $row+1;
            $kategori = new Kategori();
            $kategori->title = $value;
            $kategori->no_urut = $no;
            $kategori->image = 'categori-'.$no.'.png';
            $kategori->status = 1;
            if ($kategori->save()) {
                
            }
            # code...
        }

        for ($i = 1; $i < $faker->randomNumber(3,true); $i++) {
            $harga = $faker->numberBetween(10, 30).'0000';
            $layanan = new Layanan();
            $layanan->kategori_id = Kategori::inRandomOrder()->first()->id;
            $layanan->title = $faker->sentence();
            $layanan->konten = $faker->text();
            $layanan->harga_member = $harga;
            $layanan->harga_worker = $harga-30000;
            $layanan->featured = $faker->numberBetween(1,2);
            $layanan->image = 'service-'.$faker->numberBetween(1,9).'.jpg';
            $layanan->status = 1;
            $layanan->save();
        }
    }
}
