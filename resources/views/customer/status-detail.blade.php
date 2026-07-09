@extends('layouts.app')

@section('title', 'Status Pesanan')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-2xl font-bold mb-8">Hasil Pencarian: "{{ $cari }}"</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($pemesanans as $pemesanan)
                <div class="card-modern p-6">
                    <div class="flex justify-between items-center mb-2">
                        <h5 class="font-semibold">{{ $pemesanan->kode_pemesanan }}</h5>
                        <span class="text-sm text-gray-500">{{ $pemesanan->created_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                    <p class="mb-3 space-x-2">
                        <span class="badge-status badge-{{ $pemesanan->status_pesanan }}">{{ $pemesanan->labelStatusPesanan() }}</span>
                        <span class="badge-status badge-{{ $pemesanan->status_pembayaran }}">{{ $pemesanan->labelStatusPembayaran() }}</span>
                    </p>
                    <ul class="text-sm text-gray-500 mb-4 list-disc pl-5">
                        @foreach ($pemesanan->detailPemesanans as $detail)
                            <li>{{ $detail->jumlah }}x {{ $detail->paket->nama_paket ?? 'Paket dihapus' }}</li>
                        @endforeach
                    </ul>
                    <div class="flex justify-between items-center">
                        <strong class="text-primary">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong>
                        <a href="{{ route('pembayaran.show', $pemesanan->kode_pemesanan) }}" class="px-4 py-2 rounded-full border border-primary text-primary text-sm font-semibold">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
