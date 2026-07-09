@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-8">Pembayaran Pesanan</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card-modern p-6">
                <h5 class="font-semibold mb-2">Kode: {{ $pemesanan->kode_pemesanan }}</h5>
                <p class="mb-3 space-x-2">
                    <span class="badge-status badge-{{ $pemesanan->status_pesanan }}">{{ $pemesanan->labelStatusPesanan() }}</span>
                    <span class="badge-status badge-{{ $pemesanan->status_pembayaran }}">{{ $pemesanan->labelStatusPembayaran() }}</span>
                </p>

                <hr class="my-4">

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

                <hr class="my-4">

                <h6 class="font-semibold mb-2">Rincian Pesanan</h6>
                @foreach ($pemesanan->detailPemesanans as $detail)
                    <div class="mb-2 pb-2 border-b">
                        <div class="flex justify-between">
                            <span>{{ $detail->jumlah }}x {{ $detail->paket->nama_paket ?? 'Paket dihapus' }}</span>
                            <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Pedas: {{ str_repeat('🌶️', $detail->tingkat_pedas) }}
                            @if ($detail->kondimenTerpilih->isNotEmpty())
                                &middot; Kondimen: {{ $detail->kondimenTerpilih->map(fn($k) => $k->kondimen->nama_kondimen ?? '-')->join(', ') }}
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-between mt-3">
                    <h5 class="font-bold">Total</h5>
                    <h5 class="font-bold text-primary">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</h5>
                </div>
            </div>

            <div class="card-modern p-6">
                @if ($pemesanan->metode_pembayaran === 'qris')
                    <h5 class="font-semibold mb-3">Scan QRIS untuk Bayar</h5>

                    @if ($pengaturan->qris_url)
                        <div class="qris-box mb-4">
                            <img src="{{ $pengaturan->qris_url }}" alt="QRIS {{ $pengaturan->nama_toko }}">
                            <p class="text-sm text-gray-500 mt-2 mb-0">Scan pakai aplikasi e-wallet / m-banking favoritmu.</p>
                        </div>
                    @else
                        <div class="rounded-xl bg-amber-50 text-amber-800 text-sm p-3 mb-4">QRIS belum diatur oleh admin toko. Silakan hubungi kami untuk konfirmasi metode pembayaran.</div>
                    @endif

                    @if ($pemesanan->status_pembayaran === 'lunas')
                        <div class="rounded-xl bg-green-50 text-green-800 text-sm p-3">Pembayaran sudah kami konfirmasi. Terima kasih, pesananmu segera diproses! 🎉</div>
                    @elseif ($pemesanan->pembayaran)
                        <div class="rounded-xl bg-amber-50 text-amber-800 text-sm p-3 mb-3">Bukti pembayaran sudah kami terima, mohon tunggu konfirmasi dari kami ya.</div>
                        <img src="{{ $pemesanan->pembayaran->bukti_url }}" class="rounded-xl border w-full" alt="Bukti pembayaran">
                    @else
                        <h6 class="font-semibold mb-2">Unggah Bukti Transfer</h6>
                        <form action="{{ route('pembayaran.upload', $pemesanan->kode_pemesanan) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="file" name="bukti_transfer" class="w-full p-3 rounded-xl border" accept="image/*" required>
                            <button type="submit" class="btn-primary w-full justify-center">Kirim Bukti Pembayaran</button>
                        </form>
                    @endif
                @else
                    <h5 class="font-semibold mb-3">Pembayaran Tunai</h5>
                    <p class="text-gray-600">Silakan siapkan uang tunai. Pembayaran dilakukan saat pesanan {{ $pemesanan->tipe_pesanan === 'delivery' ? 'tiba di alamatmu' : 'diambil / disajikan' }}.</p>
                @endif

                <hr class="my-4">
                <p class="text-sm text-gray-500">
                    Simpan kode <strong>{{ $pemesanan->kode_pemesanan }}</strong> untuk cek status pesanan di
                    <a href="{{ route('status.form') }}" class="text-primary hover:underline">halaman cek status</a>.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
