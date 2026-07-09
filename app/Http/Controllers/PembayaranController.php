<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function show(string $kode)
    {
        $pemesanan = Pemesanan::with([
            'detailPemesanans.paket',
            'detailPemesanans.kondimenTerpilih.kondimen',
            'pembayaran',
        ])->where('kode_pemesanan', $kode)->firstOrFail();

        $pengaturan = Pengaturan::aktif();

        return view('customer.pembayaran', compact('pemesanan', 'pengaturan'));
    }

    public function upload(Request $request, string $kode)
    {
        $pemesanan = Pemesanan::where('kode_pemesanan', $kode)->firstOrFail();

        if ($pemesanan->status_pembayaran === 'lunas') {
            return back()->with('error', 'Pesanan ini sudah lunas, tidak perlu unggah bukti lagi.');
        }

        $validated = $request->validate([
            'bukti_transfer' => ['required', 'image', 'max:2048'],
        ]);

        $path = $validated['bukti_transfer']->store('bukti-transfer', 'public');

        Pembayaran::updateOrCreate(
            ['pemesanan_id' => $pemesanan->id],
            ['bukti_transfer' => $path, 'tanggal_bayar' => now()]
        );

        $pemesanan->update(['status_pembayaran' => 'menunggu_konfirmasi']);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Mohon tunggu konfirmasi dari kami ya!');
    }
}
