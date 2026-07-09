<?php

namespace App\Http\Controllers;

use App\Models\Kondimen;
use App\Models\Paket;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KeranjangController extends Controller
{
    public function index()
    {
        $items = session('keranjang', []);
        $total = 0;

        $items = array_map(function ($item) use (&$total) {
            $item['subtotal'] = $this->hitungSubtotal($item);
            $total += $item['subtotal'];

            return $item;
        }, $items);

        $pengaturan = Pengaturan::aktif();

        return view('customer.keranjang', compact('items', 'total', 'pengaturan'));
    }

    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'paket_id' => ['required', 'exists:pakets,id'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:20'],
            'tingkat_pedas' => ['required', 'integer', 'min:1', 'max:5'],
            'kondimen' => ['nullable', 'array'],
            'kondimen.*' => ['exists:kondimens,id'],
        ]);

        $paket = Paket::findOrFail($validated['paket_id']);

        $kondimenTerpilih = [];
        if (!empty($validated['kondimen'])) {
            $kondimens = Kondimen::whereIn('id', $validated['kondimen'])
                ->where('status', 'aktif')
                ->get();

            foreach ($kondimens as $kondimen) {
                $kondimenTerpilih[] = [
                    'id' => $kondimen->id,
                    'nama' => $kondimen->nama_kondimen,
                    'harga' => (float) $kondimen->harga,
                ];
            }
        }

        $item = [
            'id' => (string) Str::uuid(),
            'paket_id' => $paket->id,
            'nama_paket' => $paket->nama_paket,
            'harga_paket' => (float) $paket->harga,
            'jumlah' => $validated['jumlah'],
            'tingkat_pedas' => $validated['tingkat_pedas'],
            'kondimen' => $kondimenTerpilih,
        ];

        $keranjang = session('keranjang', []);
        $keranjang[] = $item;
        session(['keranjang' => $keranjang]);

        return back()->with('success', 'Berhasil ditambahkan ke keranjang: ' . $paket->nama_paket);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $keranjang = session('keranjang', []);

        foreach ($keranjang as $index => $item) {
            if ($item['id'] === $id) {
                $keranjang[$index]['jumlah'] = $validated['jumlah'];
            }
        }

        session(['keranjang' => $keranjang]);

        return back()->with('success', 'Jumlah pesanan diperbarui.');
    }

    public function hapus(string $id)
    {
        $keranjang = collect(session('keranjang', []))
            ->reject(fn ($item) => $item['id'] === $id)
            ->values()
            ->all();

        session(['keranjang' => $keranjang]);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function hitungSubtotal(array $item): float
    {
        $hargaKondimen = collect($item['kondimen'] ?? [])->sum('harga');

        return ((float) $item['harga_paket'] + (float) $hargaKondimen) * (int) $item['jumlah'];
    }
}
