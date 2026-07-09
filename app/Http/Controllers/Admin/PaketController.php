<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::orderBy('nama_paket')->paginate(10);

        return view('admin.paket.index', compact('pakets'));
    }

    public function create()
    {
        $paket = new Paket();

        return view('admin.paket.create', compact('paket'));
    }

    public function store(Request $request)
    {
        $validated = $this->validasi($request);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pakets', 'public');
        }

        Paket::create($validated);

        return redirect()->route('admin.paket.index')->with('success', 'Paket seblak berhasil ditambahkan.');
    }

    public function edit(Paket $paket)
    {
        return view('admin.paket.edit', compact('paket'));
    }

    public function update(Request $request, Paket $paket)
    {
        $validated = $this->validasi($request);

        if ($request->hasFile('gambar')) {
            if ($paket->gambar) {
                Storage::disk('public')->delete($paket->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('pakets', 'public');
        }

        $paket->update($validated);

        return redirect()->route('admin.paket.index')->with('success', 'Paket seblak berhasil diperbarui.');
    }

    public function destroy(Paket $paket)
    {
        if ($paket->gambar) {
            Storage::disk('public')->delete($paket->gambar);
        }

        $paket->delete();

        return back()->with('success', 'Paket seblak berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'kategori' => ['required', 'in:kuah,goreng,seafood,mie,lainnya'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
