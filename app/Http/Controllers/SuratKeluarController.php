<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratKeluarController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika user adalah admin, tampilkan semua surat masuk
        if ($user->role === 'admin') {
            $suratKeluar = SuratKeluar::with('kategoriSurat')->paginate(5);
            return view('admin/surat-keluar', compact('suratKeluar'));
        } else {
            // Jika user biasa, hanya tampilkan surat yang dibuat oleh user tersebut
            $suratKeluar = SuratKeluar::with('kategoriSurat')
                ->where('pembuat', $user->id)
                ->paginate(5);
            return view('admin/surat-keluar', compact('suratKeluar'));
        }
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

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Ambil data yang sesuai dengan pencarian
        $suratKeluar = SuratKeluar::where('nomor_surat', 'LIKE', "%{$query}%")
            ->orWhere('pengirim', 'LIKE', "%{$query}%")
            ->orWhere('perihal', 'LIKE', "%{$query}%")
            ->with('kategoriSurat')
            ->paginate(5) // Tetap 10 data per halaman
            ->withQueryString(); // Agar paginasi tetap berjalan

        return response()->json([
            'html' => view('admin.partial.surat-keluar.table', compact('suratKeluar'))->render()
        ]);
    }

    public function formLaporan()
    {
        return view('admin/form-laporan-surat-keluar');
    }


    public function laporan_surat(Request $request)
    {
        // Validasi input tanggal
        $validated = $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika user adalah admin, ambil semua surat keluar dalam rentang tanggal
        if ($user->role === 'admin') {
            $suratKeluar = SuratKeluar::whereBetween('tanggal_surat', [$validated['tanggal_awal'], $validated['tanggal_akhir']])
                ->with('kategoriSurat')
                ->paginate(5)
                ->withQueryString();
        } else {
            // Jika user biasa, hanya tampilkan surat yang dibuat oleh user tersebut
            $suratKeluar = SuratKeluar::where('pembuat', $user->id)
                ->whereBetween('tanggal_surat', [$validated['tanggal_awal'], $validated['tanggal_akhir']])
                ->with('kategoriSurat')
                ->paginate(5)
                ->withQueryString();
        }

        return view('admin/laporan-surat-keluar', compact('suratKeluar'));
    }


    public function exportPdf()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika admin, ambil semua surat keluar
        if ($user->role === 'admin') {
            $suratKeluar = SuratKeluar::all();
        } else {
            // Jika user biasa, hanya ambil surat keluar miliknya
            $suratKeluar = SuratKeluar::where('pembuat', $user->id)->get();
        }

        $pdf = Pdf::loadView('admin/pdf-surat-keluar', compact('suratKeluar'));
        return $pdf->download('laporan-surat-keluar.pdf');
    }
}
