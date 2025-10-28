<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans'; // atau 'penjuals' sesuai tabelmu di database

    protected $fillable = [
        'nama_produk',
        'jumlah',
        'harga',
    ];
}
