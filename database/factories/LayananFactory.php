<?php
namespace Database\Factories;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LayananFactory extends Factory
{
    protected $model = Layanan::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->randomElement(['Cuci AC', 'Ganti Freon', 'Isi Freon']),
            'harga' => $this->faker->numberBetween(50000, 250000),
        ];
    }
}
