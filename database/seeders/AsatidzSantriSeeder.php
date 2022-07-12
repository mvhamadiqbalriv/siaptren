<?php

namespace Database\Seeders;

use App\Models\Master\Asatidz;
use App\Models\Master\Santri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsatidzSantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Asatidz::factory(20)->create();
        Santri::factory(100)->create();
    }
}
