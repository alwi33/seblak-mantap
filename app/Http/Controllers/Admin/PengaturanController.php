<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function edit()
    {
        $pengaturan = Pengaturan::aktif();

        return view('admin.pengaturan.edit', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = Pengaturan::aktif();

        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'alamat_toko' => ['nullable', 'string'],
            'deskripsi_toko' => ['nullable', 'string'],
            'no_wa' => ['nullable', 'string', 'max:20'],
            'nama_rekening' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'qris_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($pengaturan->logo) {
                Storage::disk('public')->delete($pengaturan->logo);
            }
            $validated['logo'] = $request->file('logo')->store('pengaturan', 'public');
        }

        if ($request->hasFile('qris_image')) {
            if ($pengaturan->qris_image) {
                Storage::disk('public')->delete($pengaturan->qris_image);
            }
            $validated['qris_image'] = $request->file('qris_image')->store('pengaturan', 'public');
        }

        $pengaturan->update($validated);

        return back()->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}
