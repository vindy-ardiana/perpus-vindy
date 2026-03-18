<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul'         => $this->faker->sentence(4),
            'pengarang'     => $this->faker->name,
            'cover'         => null,
            'tahun_terbit'  => $this->faker->year,
            'penerbit_id'   => $this->faker->numberBetween(1, 3),
            'deskripsi'     => $this->faker->paragraph,
            'stok'          => $this->faker->numberBetween(1, 50),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Buku $buku) {
            $ids = Kategori::pluck('id')->toArray();
            if (!empty($ids)) {
                $buku->kategoris()->attach($this->faker->randomElements($ids, min(1, count($ids))));
            }
        });
    }
}
