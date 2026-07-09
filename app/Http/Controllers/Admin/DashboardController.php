<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kondimen;
use App\Models\Paket;
use App\Models\Pemesanan;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pesananHariIni = Pemesanan::whereDate('created_at', Carbon::today())->count();

        $pendapatanHariIni = Pemesanan::whereDate('created_at', Carbon::today())
            ->where('status_pembayaran', 'lunas')
            ->sum('total_harga');

        $menungguKonfirmasi = Pemesanan::where('status_pembayaran', 'menunggu_konfirmasi')->count();

        $totalPaketAktif = Paket::where('status', 'aktif')->count();
        $totalKondimenAktif = Kondimen::where('status', 'aktif')->count();

        $pesananTerbaru = Pemesanan::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'pesananHariIni',
            'pendapatanHariIni',
            'menungguKonfirmasi',
            'totalPaketAktif',
            'totalKondimenAktif',
            'pesananTerbaru'
        ));
    }
}
