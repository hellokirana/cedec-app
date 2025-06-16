<?php

namespace Database\Factories;

use App\Models\Jasa;
use Illuminate\Database\Eloquent\Factories\Factory;

class JasaFactory extends Factory
{
    protected $model = Jasa::class;

    public function definition()
    {
        return [
            'nama' => 'Service AC',
            'deskripsi' => 'Jasa perbaikan dan perawatan AC',
        ];
    }
}

