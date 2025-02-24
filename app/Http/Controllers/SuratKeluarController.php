<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use App\Models\Log;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = SuratKeluar::with('kategoriSurat')->paginate(5);
        return view('admin/surat-keluar', compact('suratKeluar'));
    }
    
    public function create(Request $request)
    {
        $kategoriSurat = KategoriSurat::all();
        return view('admin/tambah-surat-keluar', compact('kategoriSurat'));
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
        $filePath = $file->storeAs('surat_keluar', $fileName, 'public');

        $validated['file_surat'] = $filePath;
        $validated['pembuat'] = auth()->id();

        SuratKeluar::create($validated);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'Menambahkan surat keluar',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('surat-keluar.admin.index')->with('success', 'Surat keluar berhasil ditambahkan');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        $suratKeluar->delete();
        Log::create([
            'user_id' => auth()->id(),
            'action' => 'Menghapus surat keluar',
            'ip_address' => request()->ip(),
        ]);
        return redirect()->back()->with('success', 'Surat keluar berhasil dihapus');
    }   

    public function edit(SuratKeluar $suratKeluar)
    {
        $kategoriSurat = KategoriSurat::all();
        return view('admin/edit-surat-keluar', compact('suratKeluar', 'kategoriSurat'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
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
            $filePath = $file->storeAs('surat_keluar', $fileName, 'public');
            $validated['file_surat'] = $filePath;
        }

        $validated['pembuat'] = auth()->id();

        $suratKeluar->update($validated);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'Mengubah surat keluar',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('surat-keluar.admin.index')->with('success', 'Surat keluar berhasil diubah');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        return view('admin/detail-surat-keluar', compact('suratKeluar'));
    }
}
