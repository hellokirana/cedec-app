<?php

namespace Database\Seeders;

use App\Models\MasterJabatan;
use App\Models\PengaturanPengajuan;
use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

use Faker\Factory as Faker;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('id_ID');


        $data = new Website();
        $data->url = "https://tukang.co.id/";
        $data->nama = "tukang";
        $data->caption = "CV tukang";

        $data->favicon = "favicon.png";
        $data->logo = "logo.png";

        $data->map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.9918022898955!2d106.8184317758929!3d-6.395057193595509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec08612d8bed%3A0x567fbca52b1b6f8c!2sDisNakerSos%20Kota%20Depok!5e0!3m2!1sid!2sid!4v1736418981646!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        $data->alamat = "jln Merdeka";
        $data->email = "cs@email.com";
        $data->phone = "+6281343569579";

        $data->facebook = "";
        $data->instagram = "";
        $data->youtube = "";
        $data->x = "";

        $data->save();

        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'member']);
        Role::create(['name' => 'worker']);

        $super = new User();
        $super->name = 'superadmin';
        $super->email = 'superadmin@domain.com';
        $super->password = bcrypt('12345678');
        $super->no_telp = $faker->e164PhoneNumber();
        $super->alamat = $faker->address();
        $super->status = 1;
        $super->email_verified_at = \Carbon\Carbon::now();

        $super->save();
        $super->assignRole('superadmin');

        $worker = new User();
        $worker->name = 'worker';
        $worker->email = 'worker@domain.com';
        $worker->password = bcrypt('12345678');
        $worker->no_telp = $faker->e164PhoneNumber();
        $worker->alamat = $faker->address();
        $worker->status = 1;
        $worker->email_verified_at = \Carbon\Carbon::now();
        $worker->save();
        $worker->assignRole('worker');

        $member = new User();
        $member->name = 'member';
        $member->email = 'member@domain.com';
        $member->password = bcrypt('12345678');
        $member->no_telp = $faker->e164PhoneNumber();
        $member->alamat = $faker->address();
        $member->status = 1;
        $member->email_verified_at = \Carbon\Carbon::now();
        $member->save();
        $member->assignRole('member');


        for ($c = 0; $c < $faker->randomNumber(2, true); $c++) {
            $worker = new User();
            $worker->name = $faker->name();
            $worker->email = $faker->email();
            $worker->password = bcrypt('12345678');
            $worker->no_telp = $faker->e164PhoneNumber();
            $worker->alamat = $faker->address();
            $worker->status = 1;
            $worker->email_verified_at = \Carbon\Carbon::now();

            $worker->save();
            $worker->assignRole('worker');
        }

        for ($t = 0; $t < $faker->randomNumber(2, true); $t++) {
            $member = new User();
            $member->name = $faker->name();
            $member->email = $faker->email();
            $member->password = bcrypt('12345678');
            $member->no_telp = $faker->e164PhoneNumber();
            $member->alamat = $faker->address();
            $member->status = 1;
            $member->email_verified_at = \Carbon\Carbon::now();

            $member->save();
            $member->assignRole('member');
        }
    }
}
