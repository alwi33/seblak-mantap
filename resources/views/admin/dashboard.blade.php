@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-value">{{ $pesananHariIni }}</div>
            <div class="stat-label">Pesanan Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-value">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
            <div class="stat-label">Pendapatan Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-value">{{ $menungguKonfirmasi }}</div>
            <div class="stat-label">Menunggu Konfirmasi Bayar</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-value">{{ $totalPaketAktif }} / {{ $totalKondimenAktif }}</div>
            <div class="stat-label">Paket Aktif / Kondimen Aktif</div>
        </div>
    </div>
</div>

<div class="card-menu p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Pesanan Terbaru</h5>
        <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-sm btn-outline-brand">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="table table-seblak align-middle">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status Pesanan</th>
                    <th>Status Bayar</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesananTerbaru as $pesanan)
                    <tr>
                        <td><a href="{{ route('admin.pemesanan.show', $pesanan) }}">{{ $pesanan->kode_pemesanan }}</a></td>
                        <td>{{ $pesanan->nama_pelanggan }}</td>
                        <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        <td><span class="badge-status badge-{{ $pesanan->status_pesanan }}">{{ $pesanan->labelStatusPesanan() }}</span></td>
                        <td><span class="badge-status badge-{{ $pesanan->status_pembayaran }}">{{ $pesanan->labelStatusPembayaran() }}</span></td>
                        <td>{{ $pesanan->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted-brand py-4">Belum ada pesanan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
