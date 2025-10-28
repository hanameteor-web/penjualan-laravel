<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    // 🌸 Tampilkan semua data
    public function index()
    {
        $penjualan = Penjualan::all();
        return view('penjualan.index', compact('penjualan'));
    }

    // 🌸 Simpan data baru (AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::create($request->all());

        // 💡 kirim JSON supaya langsung muncul tanpa reload
        return response()->json($penjualan);
    }

    // 🌸 Ambil data detail (AJAX)
    public function show($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return response()->json($penjualan);
    }

    // 🌸 Update data (AJAX)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $penjualan->update($request->all());

        return response()->json($penjualan);
    }

    // 🌸 Hapus data (AJAX)
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();

        return response()->json(['success' => true]);
    }
}
