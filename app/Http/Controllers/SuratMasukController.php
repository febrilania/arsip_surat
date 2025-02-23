<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::all();
        return view('admin/surat-masuk', compact('suratMasuk'));
    }

    public function create()
    {
        $kategoriSurat = KategoriSurat::all();
        return view('admin/tambah-surat-masuk', compact('kategoriSurat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'file_surat' => 'required|file',
            'kategori_surat_id' => 'required|exists:kategori_surat,id',
            'isi_ringkas' => 'required|string',
            'status' => 'required|in:diterima,diproses,selesai',
        ]);

        $file = $request->file('file_surat');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('surat_masuk', $fileName, 'public');

        $validated['file_surat'] = $filePath;
        $validated['pembuat'] = auth()->id();

        SuratMasuk::create($validated);

        return redirect()->route('surat-masuk.admin.index')->with('success', 'Surat masuk berhasil ditambahkan');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        $suratMasuk->delete();
        return redirect()->back()->with('success', 'Surat masuk berhasil dihapus');
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $kategoriSurat = KategoriSurat::all();
        return view('admin/edit-surat-masuk', compact('suratMasuk', 'kategoriSurat'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'file_surat' => 'nullable|file',
            'kategori_surat_id' => 'required|exists:kategori_surat,id',
            'isi_ringkas' => 'required|string',
            'status' => 'required|in:diterima,diproses,selesai',
        ]);

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surat_masuk', $fileName, 'public');

            $validated['file_surat'] = $filePath;
        }

        $suratMasuk->update($validated);

        return redirect()->route('surat-masuk.admin.index')->with('success', 'Surat masuk berhasil diperbarui');
    }

    public function show($id)
    {
        $suratMasuk = SuratMasuk::with('kategoriSurat', 'pembuat')->findOrFail($id);
        //return response()->json($suratMasuk);
        //dd($suratMasuk->pembuat);

        return view('admin/detail-surat-masuk', compact('suratMasuk'));
    }
}
