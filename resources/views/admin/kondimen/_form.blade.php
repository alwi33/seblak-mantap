@csrf

<div class="row g-3">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label">Nama Kondimen</label>
            <input type="text" name="nama_kondimen" value="{{ old('nama_kondimen', $kondimen->nama_kondimen) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Tambahan (Rp)</label>
            <input type="number" step="0.01" min="0" name="harga" value="{{ old('harga', $kondimen->harga) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="aktif" {{ old('status', $kondimen->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif (tampil sebagai pilihan)</option>
                <option value="nonaktif" {{ old('status', $kondimen->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif (disembunyikan)</option>
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Foto Kondimen (opsional)</label>
        @if ($kondimen->gambar)
            <div class="mb-2">
                <img src="{{ $kondimen->gambar_url }}" class="img-fluid rounded border" alt="{{ $kondimen->nama_kondimen }}">
            </div>
        @endif
        <input type="file" name="gambar" class="form-control" accept="image/*">
    </div>
</div>

<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-brand">Simpan</button>
    <a href="{{ route('admin.kondimen.index') }}" class="btn btn-outline-brand">Batal</a>
</div>
