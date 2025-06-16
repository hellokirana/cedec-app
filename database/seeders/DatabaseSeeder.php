<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Layanan;
use App\Models\Jasa;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        // Create roles only if they don't exist
        $roles = ['admin', 'user', 'mitra'];
        foreach ($roles as $role) {
            if (!Role::where('name', $role)->exists()) {
                Role::create(['name' => $role]);
            }
        }

        // Create permissions only if they don't exist
        $permissions = ['manage users', 'manage transactions', 'manage services'];
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Check if admin user already exists
        if (!User::where('email', 'admin@dekat.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@dekat.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Admin No.1',
                'kode_pos' => '12345',
                'kelurahan' => 'Kelurahan Admin',
                'kecamatan' => 'Kecamatan Admin'
            ]);
            $admin->assignRole('admin');
        }

        // Seed Jasa only if it doesn't exist
        if (!Jasa::where('nama', 'Service AC')->exists()) {
            $jasa = Jasa::create(['nama' => 'Service AC', 'deskripsi' => 'Jasa perbaikan dan perawatan AC']);
        }

        // Seed Layanan only if it doesn't exist
        $layanans = [
            ['nama' => 'Cuci AC', 'harga' => 100000],
            ['nama' => 'Ganti Freon', 'harga' => 200000]
        ];

        foreach ($layanans as $layanan) {
            if (!Layanan::where('nama', $layanan['nama'])->exists()) {
                Layanan::create($layanan);
            }
        }
    }
}
