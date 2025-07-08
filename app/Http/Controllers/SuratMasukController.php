<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\Log;
use App\Models\SuratMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika user adalah admin, tampilkan semua surat masuk
        if ($user->role === 'admin') {
            $suratMasuk = SuratMasuk::with('kategoriSurat')->paginate(5);
            return view('admin/surat-masuk', compact('suratMasuk'));
        } else {
            // Jika user biasa, hanya tampilkan surat yang dibuat oleh user tersebut
            $suratMasuk = SuratMasuk::with('kategoriSurat')
                ->where('pembuat', $user->id)
                ->paginate(5);
            return view('admin/surat-masuk', compact('suratMasuk'));
        }
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

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'Menambahkan surat masuk',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('surat-masuk.admin.index')->with('success', 'Surat masuk berhasil ditambahkan');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        $suratMasuk->delete();
        Log::create([
            'user_id' => auth()->id(),
            'action' => 'Menghapus surat masuk',
            'ip_address' => request()->ip(),
        ]);
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

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'Mengubah surat masuk',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('surat-masuk.admin.index')->with('success', 'Surat masuk berhasil diperbarui');
    }

    public function show($id)
    {
        $suratMasuk = SuratMasuk::with('kategoriSurat', 'pembuat')->findOrFail($id);
        //return response()->json($suratMasuk);
        //dd($suratMasuk->pembuat);

        return view('admin/detail-surat-masuk', compact('suratMasuk'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Ambil data yang sesuai dengan pencarian
        $suratMasuk = SuratMasuk::where('nomor_surat', 'LIKE', "%{$query}%")
            ->orWhere('pengirim', 'LIKE', "%{$query}%")
            ->orWhere('perihal', 'LIKE', "%{$query}%")
            ->with('kategoriSurat')
            ->paginate(5) // Tetap 10 data per halaman
            ->withQueryString(); // Agar paginasi tetap berjalan

        return response()->json([
            'html' => view('admin.partial.surat-masuk.table', compact('suratMasuk'))->render()
        ]);
    }

    public function formLaporan()
    {
        return view('admin/form-laporan-surat-masuk');
    }

    public function laporan_surat(Request $request)
    {
        // Validasi input tanggal
        $validated = $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ],[
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh lebih kecil dari tanggal awal.',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika user adalah admin, ambil semua surat keluar dalam rentang tanggal
        if ($user->role === 'admin') {
            $suratMasuk = SuratMasuk::whereBetween('tanggal_surat', [$validated['tanggal_awal'], $validated['tanggal_akhir']])
                ->with('kategoriSurat')
                ->paginate(5)
                ->withQueryString();
        } else {
            // Jika user biasa, hanya tampilkan surat yang dibuat oleh user tersebut
            $suratMasuk = SuratMasuk::where('pembuat', $user->id)
                ->whereBetween('tanggal_surat', [$validated['tanggal_awal'], $validated['tanggal_akhir']])
                ->with('kategoriSurat')
                ->paginate(5)
                ->withQueryString();
        }

        return view('admin/laporan-surat-masuk', compact('suratMasuk'));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Validasi tanggal (optional tapi disarankan)
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        if ($user->role === 'admin') {
            $query = SuratMasuk::query();
        } else {
            $query = SuratMasuk::where('pembuat', $user->id);
        }

        // Filter berdasarkan rentang tanggal
        $query->whereBetween('tanggal_surat', [$tanggalAwal, $tanggalAkhir]);

        $suratMasuk = $query->with('kategoriSurat')->get();

        $pdf = Pdf::loadView('admin/pdf-surat-masuk', compact('suratMasuk', 'tanggalAwal', 'tanggalAkhir'));
        return $pdf->download("laporan-surat-masuk-{$tanggalAwal}_{$tanggalAkhir}.pdf");
    }
}
