<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => Str::uuid(),
                'title' => 'Laravel Fundamental',
                'description' => 'Pelatihan dasar Laravel untuk pemula.',
                'image' => 'images/workshops/laravel.png',
                'workshop_start_date' => Carbon::parse('2025-07-01 10:00'),
                'workshop_end_date' => Carbon::parse('2025-07-01 15:00'),
                'time' => '10:00 - 15:00',
                'place' => 'Jakarta',
                'fee' => 0,
                'quota' => 50,
                'status' => 1,
                'registration_start_date' => Carbon::parse('2025-06-15 09:00'),
                'registration_end_date' => Carbon::parse('2025-06-30 23:59'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Vue.js Intermediate',
                'description' => 'Pelatihan tingkat menengah Vue.js.',
                'image' => 'images/workshops/vue.png',
                'workshop_start_date' => Carbon::parse('2025-07-05 09:00'),
                'workshop_end_date' => Carbon::parse('2025-07-05 14:00'),
                'time' => '09:00 - 14:00',
                'place' => 'Bandung',
                'fee' => 150000,
                'quota' => 40,
                'status' => 1,
                'registration_start_date' => Carbon::parse('2025-06-20 09:00'),
                'registration_end_date' => Carbon::parse('2025-07-03 23:59'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'UI/UX Design Sprint',
                'description' => 'Workshop intensif desain UI/UX.',
                'image' => 'images/workshops/uiux.png',
                'workshop_start_date' => Carbon::parse('2025-07-10 13:00'),
                'workshop_end_date' => Carbon::parse('2025-07-10 17:00'),
                'time' => '13:00 - 17:00',
                'place' => 'Online via Zoom',
                'fee' => 100000,
                'quota' => 100,
                'status' => 2,
                'registration_start_date' => Carbon::parse('2025-06-18 08:00'),
                'registration_end_date' => Carbon::parse('2025-07-09 23:59'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Data Science Bootcamp',
                'description' => 'Pelatihan intensif pengolahan data dan machine learning.',
                'image' => 'images/workshops/datascience.png',
                'workshop_start_date' => Carbon::parse('2025-07-15 08:00'),
                'workshop_end_date' => Carbon::parse('2025-07-15 17:00'),
                'time' => '08:00 - 17:00',
                'place' => 'Yogyakarta',
                'fee' => 250000,
                'quota' => 30,
                'status' => 1,
                'registration_start_date' => Carbon::parse('2025-06-22 09:00'),
                'registration_end_date' => Carbon::parse('2025-07-13 23:59'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Cybersecurity Essentials',
                'description' => 'Pengenalan keamanan sistem informasi dan jaringan.',
                'image' => 'images/workshops/cyber.png',
                'workshop_start_date' => Carbon::parse('2025-07-20 10:00'),
                'workshop_end_date' => Carbon::parse('2025-07-20 13:00'),
                'time' => '10:00 - 13:00',
                'place' => 'Surabaya',
                'fee' => 0,
                'quota' => 80,
                'status' => 3,
                'registration_start_date' => Carbon::parse('2025-06-25 08:00'),
                'registration_end_date' => Carbon::parse('2025-07-18 23:59'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('workshops')->insert($data);
    }
}
