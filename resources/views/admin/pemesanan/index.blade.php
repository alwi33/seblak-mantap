@extends('layouts.admin')

@section('title', 'Pesanan Masuk')

@section('content')
<div class="mb-3 d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-sm {{ !$status ? 'btn-brand' : 'btn-outline-brand' }}">Semua</a>
    <a href="{{ route('admin.pemesanan.index', ['status' => 'menunggu_konfirmasi']) }}" class="btn btn-sm {{ $status === 'menunggu_konfirmasi' ? 'btn-brand' : 'btn-outline-brand' }}">Menunggu Konfirmasi</a>
    <a href="{{ route('admin.pemesanan.index', ['status' => 'lunas']) }}" class="btn btn-sm {{ $status === 'lunas' ? 'btn-brand' : 'btn-outline-brand' }}">Lunas</a>
    <a href="{{ route('admin.pemesanan.index', ['status' => 'belum_bayar']) }}" class="btn btn-sm {{ $status === 'belum_bayar' ? 'btn-brand' : 'btn-outline-brand' }}">Belum Bayar</a>
</div>

<div class="card-menu p-4">
    <div class="table-responsive">
        <table class="table table-seblak align-middle">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Tipe</th>
                    <th>Total</th>
                    <th>Status Pesanan</th>
                    <th>Status Bayar</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesanans as $pemesanan)
                    <tr>
                        <td>{{ $pemesanan->kode_pemesanan }}</td>
                        <td>{{ $pemesanan->nama_pelanggan }}</td>
                        <td>{{ $pemesanan->labelTipePesanan() }}</td>
                        <td>Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                        <td><span class="badge-status badge-{{ $pemesanan->status_pesanan }}">{{ $pemesanan->labelStatusPesanan() }}</span></td>
                        <td><span class="badge-status badge-{{ $pemesanan->status_pembayaran }}">{{ $pemesanan->labelStatusPembayaran() }}</span></td>
                        <td>{{ $pemesanan->created_at->diffForHumans() }}</td>
                        <td><a href="{{ route('admin.pemesanan.show', $pemesanan) }}" class="btn btn-sm btn-outline-brand">Detail</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted-brand py-4">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $pemesanans->links() }}
    </div>
</div>
@endsection
