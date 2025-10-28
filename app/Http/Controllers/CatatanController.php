<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use Illuminate\Http\Request;

class CatatanController extends Controller
{
    public function index()
    {
        $catatan = Catatan::all();
        return view('catatan.index', compact('catatan'));
    }

    public function create()
    {
        return view('catatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required'
        ]);

        Catatan::create($request->all());
        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dibuat!');
    }

    public function edit(Catatan $catatan)
    {
        return view('catatan.edit', compact('catatan'));
    }

    public function update(Request $request, Catatan $catatan)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required'
        ]);

        $catatan->update($request->all());
        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil diperbarui!');
    }

    public function destroy(Catatan $catatan)
    {
        $catatan->delete();
        return redirect()->route('catatan.index')->with('success', 'Catatan dihapus!');
    }
}
