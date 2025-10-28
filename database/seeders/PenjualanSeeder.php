<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        DB::table('penjualans')->insert([
            [
                'nama_produk' => 'Laptop ASUS Vivobook',
                'jumlah' => 3,
                'harga' => 8500000,
            ],
            [
                'nama_produk' => 'Mouse Logitech',
                'jumlah' => 10,
                'harga' => 250000,
            ],
            [
                'nama_produk' => 'Keyboard Rexus',
                'jumlah' => 5,
                'harga' => 350000,
            ],
        ]);
    }
}
