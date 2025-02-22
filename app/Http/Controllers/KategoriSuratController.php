<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class KategoriSuratController extends Controller
{
    public function index()
    {
        $kategori = KategoriSurat::all();
        return view('admin/kategori-surat', compact('kategori'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategori_surat|string|max:255',
            'deskripsi' => 'required|string',
        ]);
        KategoriSurat::create($validated);
        return redirect()->back()->with('success', 'Kategori surat berhasil ditambahkan');
    }

    public function destroy(KategoriSurat $kategori)
    {
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori surat berhasil dihapus');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriSurat::findOrFail($id);
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);
        $kategori->update($validated);
        return redirect()->back()->with('success', 'Kategori surat berhasil diubah');
    }
}
