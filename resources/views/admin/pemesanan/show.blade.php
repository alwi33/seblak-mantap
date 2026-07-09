@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card-menu p-4">
            <h5 class="mb-3">{{ $pemesanan->kode_pemesanan }}</h5>
            <p class="mb-1"><strong>Nama:</strong> {{ $pemesanan->nama_pelanggan }}</p>
            <p class="mb-1"><strong>No. HP:</strong> {{ $pemesanan->no_hp }}</p>
            <p class="mb-1"><strong>Tipe Pesanan:</strong> {{ $pemesanan->labelTipePesanan() }}</p>
            @if ($pemesanan->meja)
                <p class="mb-1"><strong>Meja:</strong> {{ $pemesanan->meja }}</p>
            @endif
            @if ($pemesanan->alamat_pengiriman)
                <p class="mb-1"><strong>Alamat:</strong> {{ $pemesanan->alamat_pengiriman }}</p>
            @endif
            @if ($pemesanan->catatan)
                <p class="mb-1"><strong>Catatan:</strong> {{ $pemesanan->catatan }}</p>
            @endif
            <p class="mb-1"><strong>Metode Bayar:</strong> {{ strtoupper($pemesanan->metode_pembayaran) }}</p>
            <p class="mb-3"><strong>Waktu Pesan:</strong> {{ $pemesanan->created_at->translatedFormat('d M Y, H:i') }}</p>

            <hr>

            <h6 class="mb-2">Rincian Pesanan</h6>
            @foreach ($pemesanan->detailPemesanans as $detail)
                <div class="mb-2 pb-2 border-bottom">
                    <div class="d-flex justify-content-between">
                        <span>{{ $detail->jumlah }}x {{ $detail->paket->nama_paket ?? 'Paket dihapus' }}</span>
                        <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="small text-muted-brand">
                        Pedas: {{ str_repeat('🌶️', $detail->tingkat_pedas) }}
                        @if ($detail->kondimenTerpilih->isNotEmpty())
                            &middot; Kondimen: {{ $detail->kondimenTerpilih->map(fn($k) => $k->kondimen->nama_kondimen ?? '-')->join(', ') }}
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-between mt-2">
                <h5 class="mb-0">Total</h5>
                <h5 class="mb-0 text-brand-red">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card-menu p-4 mb-4">
            <h6 class="mb-2">Status Saat Ini</h6>
            <p class="mb-3">
                <span class="badge-status badge-{{ $pemesanan->status_pesanan }}">{{ $pemesanan->labelStatusPesanan() }}</span>
                <span class="badge-status badge-{{ $pemesanan->status_pembayaran }}">{{ $pemesanan->labelStatusPembayaran() }}</span>
            </p>

            @if ($pemesanan->metode_pembayaran === 'qris')
                @if ($pemesanan->pembayaran)
                    <p class="small text-muted-brand mb-1">Bukti transfer dari pelanggan:</p>
                    <img src="{{ $pemesanan->pembayaran->bukti_url }}" class="img-fluid rounded border mb-3" alt="Bukti pembayaran">

                    @if ($pemesanan->status_pembayaran === 'menunggu_konfirmasi')
                        <form action="{{ route('admin.pemesanan.konfirmasi-bayar', $pemesanan) }}" method="POST">
                            @csrf
                            <div class="d-grid">
                                <button type="submit" class="btn btn-brand">Konfirmasi Pembayaran Ini</button>
                            </div>
                        </form>
                    @elseif ($pemesanan->pembayaran->tanggal_konfirmasi)
                        <p class="small text-muted-brand mb-0">
                            Dikonfirmasi oleh {{ $pemesanan->pembayaran->confirmedBy->name ?? '-' }}
                            pada {{ $pemesanan->pembayaran->tanggal_konfirmasi->translatedFormat('d M Y, H:i') }}.
                        </p>
                    @endif
                @else
                    <p class="small text-muted-brand mb-0">Pelanggan belum mengunggah bukti pembayaran.</p>
                @endif
            @else
                <p class="small text-muted-brand mb-0">Pesanan ini menggunakan pembayaran tunai.</p>
            @endif
        </div>

        <div class="card-menu p-4">
            <h6 class="mb-2">Perbarui Status Pesanan</h6>
            <form action="{{ route('admin.pemesanan.update-status', $pemesanan) }}" method="POST" class="d-flex gap-2">
                @csrf
                <select name="status_pesanan" class="form-select">
                    @foreach (['menunggu_pembayaran' => 'Menunggu Pembayaran', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'] as $value => $label)
                        <option value="{{ $value }}" {{ $pemesanan->status_pesanan === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-brand text-nowrap">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
