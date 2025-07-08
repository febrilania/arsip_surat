<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public static function getDashboardData()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        $months = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('F'));

        $suratMasukQuery = DB::table('surat_masuk')
            ->selectRaw('MONTH(tanggal_terima) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_terima', now()->year);

        $suratKeluarQuery = DB::table('surat_keluar')
            ->selectRaw('MONTH(tanggal_terima) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_terima', now()->year);

        if (!$isAdmin) {
            $suratMasukQuery->where('pembuat', $user->id);
            $suratKeluarQuery->where('pembuat', $user->id);
        }

        $suratMasukPerBulan = $suratMasukQuery->groupBy('bulan')->pluck('total', 'bulan');
        $suratKeluarPerBulan = $suratKeluarQuery->groupBy('bulan')->pluck('total', 'bulan');

        $kategoriMasuk = DB::table('kategori_surat')
            ->leftJoin('surat_masuk', 'kategori_surat.id', '=', 'surat_masuk.kategori_surat_id')
            ->select('kategori_surat.nama_kategori', DB::raw('COUNT(surat_masuk.id) as total'))
            ->when(!$isAdmin, fn($query) => $query->where('surat_masuk.pembuat', $user->id))
            ->groupBy('kategori_surat.nama_kategori')
            ->pluck('total', 'nama_kategori');

        $statusMasuk = DB::table('surat_masuk')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->when(!$isAdmin, fn($query) => $query->where('pembuat', $user->id))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusKeluar = DB::table('surat_keluar')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->when(!$isAdmin, fn($query) => $query->where('pembuat', $user->id))
            ->groupBy('status')
            ->pluck('total', 'status');

        $logHarian = DB::table('logs')
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->when(!$isAdmin, fn($query) => $query->where('user_id', $user->id))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        return compact(
            'months',
            'suratMasukPerBulan',
            'suratKeluarPerBulan',
            'kategoriMasuk',
            'statusMasuk',
            'statusKeluar',
            'logHarian'
        );
    }
}
