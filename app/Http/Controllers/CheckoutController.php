<?php

namespace App\Http\Controllers;

use App\Models\DetailPemesanan;
use App\Models\DetailPemesananKondimen;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang kamu masih kosong, yuk pilih seblak favoritmu dulu.');
        }

        $validated = $request->validate([
            'nama_pelanggan' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
            'tipe_pesanan' => ['required', 'in:makan_di_tempat,bawa_pulang,delivery'],
            'meja' => ['nullable', 'required_if:tipe_pesanan,makan_di_tempat', 'string', 'max:50'],
            'alamat_pengiriman' => ['nullable', 'required_if:tipe_pesanan,delivery', 'string'],
            'catatan' => ['nullable', 'string'],
            'metode_pembayaran' => ['required', 'in:qris,cash'],
        ]);

        $pemesanan = DB::transaction(function () use ($validated, $keranjang) {
            $pemesanan = Pemesanan::create([
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'no_hp' => $validated['no_hp'],
                'tipe_pesanan' => $validated['tipe_pesanan'],
                'meja' => $validated['meja'] ?? null,
                'alamat_pengiriman' => $validated['alamat_pengiriman'] ?? null,
                'catatan' => $validated['catatan'] ?? null,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'total_harga' => 0,
            ]);

            $totalHarga = 0;

            foreach ($keranjang as $item) {
                $hargaKondimen = collect($item['kondimen'] ?? [])->sum('harga');
                $subtotal = ((float) $item['harga_paket'] + (float) $hargaKondimen) * (int) $item['jumlah'];

                $detail = DetailPemesanan::create([
                    'pemesanan_id' => $pemesanan->id,
                    'paket_id' => $item['paket_id'],
                    'jumlah' => $item['jumlah'],
                    'tingkat_pedas' => $item['tingkat_pedas'],
                    'harga_satuan' => $item['harga_paket'],
                    'subtotal' => $subtotal,
                ]);

                foreach (($item['kondimen'] ?? []) as $kondimen) {
                    DetailPemesananKondimen::create([
                        'detail_pemesanan_id' => $detail->id,
                        'kondimen_id' => $kondimen['id'],
                        'harga_satuan' => $kondimen['harga'],
                    ]);
                }

                $totalHarga += $subtotal;
            }

            $pemesanan->update(['total_harga' => $totalHarga]);

            return $pemesanan;
        });

        session()->forget('keranjang');

        return redirect()->route('pembayaran.show', $pemesanan->kode_pemesanan)
            ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
    }
}
