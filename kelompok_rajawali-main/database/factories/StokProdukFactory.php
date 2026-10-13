<?php

namespace Database\Factories;

use App\Models\StokProduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StokProduk>
 */
class StokProdukFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'produk_id' => fake()->unique()->numberBetween(1, 10),
            'stok' => fake()->numberBetween(0, 50),
        ];
    }
}
