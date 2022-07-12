<?php

namespace Database\Factories;

use App\Models\Master\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SantriFactory extends Factory
{
    protected $model = Santri::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sufix = $this->faker->randomNumber(3);
        $status = $this->faker->randomElement([null, 'Aktif', 'Lulus']);
        return [
            'kode_santri' => 'ST' . $this->faker->date('ym') . sprintf('%03s', $sufix),
            'nama_lengkap' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'tanggal_lahir' => $this->faker->date(),
            'tempat_lahir' => $this->faker->city(),
            'universitas' => $this->faker->university,
            'fakultas' => $this->faker->campus,
            'prodi' => $this->faker->course,
            'semester' => rand(1, 8),
            'nomor_handphone' => substr($this->faker->e164PhoneNumber(), 0, 15),
            'alamat' => $this->faker->address(),
            'email' => $this->faker->unique()->email(),
            'status' => $status,
            'pekerjaan' => $status == 'Lulus' ? $this->faker->jobTitle() : null,
            'tahun_masuk' => $this->faker->year(),
            'tahun_lulus' => $status == 'Lulus' ? $this->faker->year() : null,
        ];
    }
}
