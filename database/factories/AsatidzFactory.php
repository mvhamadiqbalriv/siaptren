<?php

namespace Database\Factories;

use App\Models\Master\Asatidz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AsatidzFactory extends Factory
{
    protected $model = Asatidz::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sufix = $this->faker->randomNumber(3);
        return [
            'kode_asatidz' => 'UST' . $this->faker->date('ym') . sprintf("%03s", $sufix),
            'nik' => $this->faker->randomNumber(),
            'nama_lengkap' => $this->faker->name(),
            'tanggal_lahir' => $this->faker->date(),
            'tempat_lahir' => $this->faker->city(),
            'upah_pertemuan' => $this->faker->numerify('#####'),
            'aktif' => $this->faker->randomElement([0, 1])
        ];
    }
}
