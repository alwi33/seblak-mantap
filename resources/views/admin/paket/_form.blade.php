@csrf

<div class="row g-3">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label">Nama Paket</label>
            <input type="text" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" step="0.01" min="0" name="harga" value="{{ old('harga', $paket->harga) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select" required>
                    @foreach (['kuah' => 'Kuah', 'goreng' => 'Goreng', 'seafood' => 'Seafood', 'mie' => 'Mie', 'lainnya' => 'Lainnya'] as $value => $label)
                        <option value="{{ $value }}" {{ old('kategori', $paket->kategori) == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="aktif" {{ old('status', $paket->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif (tampil di menu)</option>
                <option value="nonaktif" {{ old('status', $paket->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif (disembunyikan)</option>
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Foto Menu</label>
        @if ($paket->gambar)
            <div class="mb-2">
                <img src="{{ $paket->gambar_url }}" class="img-fluid rounded border" alt="{{ $paket->nama_paket }}">
            </div>
        @endif
        <input type="file" name="gambar" class="form-control" accept="image/*">
        <p class="small text-muted-brand mt-1 mb-0">Kosongkan jika tidak ingin mengganti foto. Bisa juga diisi belakangan langsung lewat MySQL / tabel <code>pakets</code> kolom <code>gambar</code>.</p>
    </div>
</div>

<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-brand">Simpan</button>
    <a href="{{ route('admin.paket.index') }}" class="btn btn-outline-brand">Batal</a>
</div>
