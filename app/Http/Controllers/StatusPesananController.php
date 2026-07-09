<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class StatusPesananController extends Controller
{
    public function form()
    {
        return view('customer.cek-status');
    }

    public function cek(Request $request)
    {
        $validated = $request->validate([
            'cari' => ['required', 'string', 'max:255'],
        ]);

        $cari = $validated['cari'];

        $pemesanans = Pemesanan::with('detailPemesanans.paket')
            ->where('kode_pemesanan', $cari)
            ->orWhere('no_hp', $cari)
            ->latest()
            ->get();

        if ($pemesanans->isEmpty()) {
            return back()->with('error', 'Pesanan tidak ditemukan. Cek kembali kode pesanan atau nomor HP yang dimasukkan.');
        }

        return view('customer.status-detail', compact('pemesanans', 'cari'));
    }
}
