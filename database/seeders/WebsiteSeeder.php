<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Website;
use App\Models\Role;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // seed website
        Website::firstOrCreate([
            'url'     => 'https://cedec.co.id/',
            'nama'    => 'CEdEC JGU',
            'caption' => 'CEdEC JGU',
            'favicon' => 'favicon.png',
            'logo'    => 'logo.png',
        ]);

        // seed roles
        Role::firstOrCreate(['name' => 'superadmin']);
        Role::firstOrCreate(['name' => 'student']);

        // ambil semua program_id (seharusnya sudah ada via ProgramSeeder)
        $programIds = Program::pluck('id')->toArray();

        // superadmin (nullable, jadi kita biarkan tanpa program_id)
        $super = User::firstOrCreate(
            ['email' => 'superadmin@cedec.com'],
            [
                'name'              => 'superadmin',
                'password'          => bcrypt('12345678'),
                'status'            => 1,
                'npm'               => $faker->creditCardNumber(), // jika wajib
                'email_verified_at' => Carbon::now(),
            ]
        );
        $super->assignRole('superadmin');

        // satu user student tetap terdefinisi program_id
        $student = User::firstOrCreate(
            ['email' => 'student@cedec.com'],
            [
                'name'              => 'student',
                'password'          => bcrypt('12345678'),
                'status'            => 1,
                'npm'               => $faker->creditCardNumber(),
                'program_id'        => $faker->optional()->randomElement($programIds),
                'email_verified_at' => Carbon::now(),
            ]
        );
        $student->assignRole('student');

        // generate beberapa student lagi
        for ($i = 0; $i < $faker->numberBetween(2, 5); $i++) {
            $u = User::create([
                'name'              => 'student',
                'email'             => $faker->unique()->safeEmail(),
                'password'          => bcrypt('12345678'),
                'status'            => 1,
                'npm'               => $faker->creditCardNumber(),
                'program_id'        => $faker->randomElement($programIds),
                'email_verified_at' => Carbon::now(),
            ]);
            $u->assignRole('student');
        }
    }
}
