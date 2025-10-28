<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // ✅ Tambahkan ini agar DB::raw() dikenali

return new class extends Migration
{
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->integer('jumlah');
            $table->decimal('harga', 15, 2);
            $table->date('tanggal_penjualan')->default(DB::raw('CURRENT_DATE')); // 📅 otomatis tanggal hari ini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan'); // ✅ tanpa huruf 's'
    }
};
