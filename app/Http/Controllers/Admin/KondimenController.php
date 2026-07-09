<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kondimen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KondimenController extends Controller
{
    public function index()
    {
        $kondimens = Kondimen::orderBy('nama_kondimen')->paginate(10);

        return view('admin.kondimen.index', compact('kondimens'));
    }

    public function create()
    {
        $kondimen = new Kondimen();

        return view('admin.kondimen.create', compact('kondimen'));
    }

    public function store(Request $request)
    {
        $validated = $this->validasi($request);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kondimen', 'public');
        }

        Kondimen::create($validated);

        return redirect()->route('admin.kondimen.index')->with('success', 'Kondimen berhasil ditambahkan.');
    }

    public function edit(Kondimen $kondimen)
    {
        return view('admin.kondimen.edit', compact('kondimen'));
    }

    public function update(Request $request, Kondimen $kondimen)
    {
        $validated = $this->validasi($request);

        if ($request->hasFile('gambar')) {
            if ($kondimen->gambar) {
                Storage::disk('public')->delete($kondimen->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('kondimen', 'public');
        }

        $kondimen->update($validated);

        return redirect()->route('admin.kondimen.index')->with('success', 'Kondimen berhasil diperbarui.');
    }

    public function destroy(Kondimen $kondimen)
    {
        if ($kondimen->gambar) {
            Storage::disk('public')->delete($kondimen->gambar);
        }

        $kondimen->delete();

        return back()->with('success', 'Kondimen berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama_kondimen' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
