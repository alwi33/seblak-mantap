@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="card-menu p-4">
    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Nama Toko</label>
                    <input type="text" name="nama_toko" value="{{ old('nama_toko', $pengaturan->nama_toko) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Toko</label>
                    <textarea name="alamat_toko" class="form-control" rows="2">{{ old('alamat_toko', $pengaturan->alamat_toko) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi / Tagline Toko</label>
                    <textarea name="deskripsi_toko" class="form-control" rows="3" placeholder="Contoh: Seblak dengan bumbu autentik, topping melimpah, dan rasa pedas yang pas untuk semua lidah.">{{ old('deskripsi_toko', $pengaturan->deskripsi_toko) }}</textarea>
                    <p class="small text-muted-brand mt-1 mb-0">Teks ini tampil di halaman utama (bagian Tentang &amp; hero).</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" value="{{ old('no_wa', $pengaturan->no_wa) }}" class="form-control" placeholder="628xxxxxxxxxx">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Pemilik Rekening / QRIS (opsional)</label>
                    <input type="text" name="nama_rekening" value="{{ old('nama_rekening', $pengaturan->nama_rekening) }}" class="form-control">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Logo Toko</label>
                @if ($pengaturan->logo_url)
                    <div class="mb-2">
                        <img src="{{ $pengaturan->logo_url }}" class="img-fluid rounded border" style="max-width:120px;" alt="Logo {{ $pengaturan->nama_toko }}">
                    </div>
                @else
                    <div class="alert alert-warning small">Belum ada logo. Unggah logo toko (format PNG transparan disarankan).</div>
                @endif
                <input type="file" name="logo" class="form-control mb-3" accept="image/*">
                <p class="small text-muted-brand mt-1">Logo ini otomatis dipakai di navbar &amp; footer halaman pelanggan.</p>

                <label class="form-label mt-2">Gambar QRIS Statis</label>
                @if ($pengaturan->qris_url)
                    <div class="qris-box mb-2">
                        <img src="{{ $pengaturan->qris_url }}" alt="QRIS">
                    </div>
                @else
                    <div class="alert alert-warning small">Belum ada gambar QRIS. Unggah screenshot QRIS statis dari aplikasi e-wallet / m-banking toko kamu.</div>
                @endif
                <input type="file" name="qris_image" class="form-control" accept="image/*">
                <p class="small text-muted-brand mt-1">Gunakan QRIS statis (dari GoPay/DANA/OVO/ShopeePay/Mobile Banking) yang sudah dimiliki toko. Untuk QRIS dinamis otomatis, perlu integrasi payment gateway seperti Midtrans/Xendit secara terpisah.</p>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-brand">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection
