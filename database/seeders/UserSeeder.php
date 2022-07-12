<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create user
        User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@siap.tren',
            'no_hp' => '123456789',
            'password' => bcrypt('siap.tren'),
            'jabatan' => 'Admin',
        ])->assignRole('admin');

        User::create([
            'nama_lengkap' => 'Bendahara',
            'username' => 'bendahara',
            'email' => 'bendahara@siap.tren',
            'no_hp' => '123456789',
            'password' => bcrypt('siap.tren'),
            'jabatan' => 'Bendahara',
        ])->assignRole('bendahara');

        User::create([
            'nama_lengkap' => 'Pimpinan Pesantren',
            'username' => 'pimpinan_pesantren',
            'email' => 'pimpinan_pesantren@siap.tren',
            'no_hp' => '123456789',
            'password' => bcrypt('siap.tren'),
            'jabatan' => 'Pimpinan Pesantren',
        ])->assignRole('pimpinan_pesantren');
    }
}
