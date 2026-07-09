<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Pemesanan::latest();

        if ($status) {
            $query->where('status_pembayaran', $status);
        }

        $pemesanans = $query->paginate(10)->withQueryString();

        return view('admin.pemesanan.index', compact('pemesanans', 'status'));
    }

    public function show(Pemesanan $pemesanan)
    {
        $pemesanan->load([
            'detailPemesanans.paket',
            'detailPemesanans.kondimenTerpilih.kondimen',
            'pembayaran.confirmedBy',
        ]);

        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    public function konfirmasiBayar(Pemesanan $pemesanan)
    {
        if (!$pemesanan->pembayaran) {
            return back()->with('error', 'Belum ada bukti pembayaran yang diunggah pelanggan.');
        }

        $pemesanan->update([
            'status_pembayaran' => 'lunas',
            'status_pesanan' => 'diproses',
        ]);

        $pemesanan->pembayaran->update([
            'dikonfirmasi_oleh' => auth()->id(),
            'tanggal_konfirmasi' => now(),
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        $validated = $request->validate([
            'status_pesanan' => ['required', 'in:menunggu_pembayaran,diproses,selesai,dibatalkan'],
        ]);

        $pemesanan->update($validated);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
