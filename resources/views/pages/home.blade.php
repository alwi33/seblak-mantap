@extends('layouts.app')

@section('title','Seblak Juara')

@section('content')
    @include('components.hero')

    <section id="menu-list" class="py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-8 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Menu Seblak</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pakets as $paket)
                    <div>
                        @include('components.menu-card', ['paket' => $paket, 'kondimens' => $kondimens])
                    </div>
                @empty
                    <div class="col-span-3">Belum ada paket aktif.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="promo" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold">Promo Spesial</h2>
                <p class="text-gray-600 mt-2">Nikmati harga spesial dan bebas ongkir untuk pesanan pertama.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card-modern p-6 text-center">
                    <h3 class="font-semibold">Diskon 10%</h3>
                    <p class="mt-2 text-sm text-gray-600">Untuk pembelian paket besar.</p>
                </div>
                <div class="card-modern p-6 text-center">
                    <h3 class="font-semibold">Ongkir Murah</h3>
                    <p class="mt-2 text-sm text-gray-600">Akses promo antar murah setiap hari.</p>
                </div>
                <div class="card-modern p-6 text-center">
                    <h3 class="font-semibold">Menu Baru</h3>
                    <p class="mt-2 text-sm text-gray-600">Coba topping spesial terbaru kami.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-12">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-3xl font-bold">Tentang {{ $pengaturan->nama_toko }}</h2>
                <p class="mt-4 text-gray-600">{{ $pengaturan->deskripsi_toko ?: 'Kami membuat seblak dengan bumbu autentik, topping melimpah, dan rasa pedas yang pas untuk semua lidah.' }}</p>
                <ul class="mt-6 space-y-3 text-gray-700">
                    <li>• Bahan berkualitas</li>
                    <li>• Resep spesial</li>
                    <li>• Siap antar sampai rumah</li>
                </ul>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <img src="{{ asset('assets/gb1.png') }}" alt="{{ $pengaturan->nama_toko }}" class="w-full rounded-2xl object-cover shadow-modern" loading="lazy">
                <img src="{{ asset('assets/gb2.png') }}" alt="{{ $pengaturan->nama_toko }}" class="w-full rounded-2xl object-cover shadow-modern" loading="lazy">
            </div>
        </div>
    </section>

    <section id="kontak" class="py-12 bg-[#fff4e6]">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-3xl font-bold">Kontak Kami</h2>
                <p class="mt-4 text-gray-600">Hubungi kami untuk pesanan, promo, dan kerjasama bisnis.</p>
                <div class="mt-6 space-y-3 text-gray-700">
                    @if ($pengaturan->no_wa)
                        <p>WhatsApp: <a href="https://wa.me/{{ $pengaturan->no_wa }}" target="_blank" class="text-primary hover:underline">{{ $pengaturan->no_wa }}</a></p>
                    @endif
                    @if ($pengaturan->alamat_toko)
                        <p>Alamat: {{ $pengaturan->alamat_toko }}</p>
                    @endif
                </div>
            </div>
            <div class="card-modern p-6 bg-white flex flex-col justify-center">
                <h3 class="font-semibold mb-2">Pesan lebih cepat lewat WhatsApp</h3>
                <p class="text-sm text-gray-600 mb-4">Tim kami akan langsung membalas untuk bantu proses pesananmu.</p>
                @if ($pengaturan->no_wa)
                    <a href="https://wa.me/{{ $pengaturan->no_wa }}" target="_blank" class="btn-primary justify-center">Chat via WhatsApp</a>
                @else
                    <p class="text-sm text-gray-500">Nomor WhatsApp toko belum diatur oleh admin.</p>
                @endif
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-paket-card]').forEach(function (card) {
    const hargaPaket = parseFloat(card.dataset.hargaPaket);
    const jumlahInput = card.querySelector('.input-jumlah');
    const kondimenInputs = card.querySelectorAll('.input-kondimen');
    const totalEl = card.querySelector('.live-total');

    function formatRupiah(angka) {
        return 'Rp ' + Math.round(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function hitungUlang() {
        let hargaKondimen = 0;
        kondimenInputs.forEach(function (input) {
            if (input.checked) {
                hargaKondimen += parseFloat(input.dataset.harga);
            }
        });
        const jumlah = parseInt(jumlahInput.value || '1', 10);
        const total = (hargaPaket + hargaKondimen) * jumlah;
        if (totalEl) {
            totalEl.textContent = formatRupiah(total);
        }
    }

    if (jumlahInput) jumlahInput.addEventListener('input', hitungUlang);
    kondimenInputs.forEach(function (input) {
        input.addEventListener('change', hitungUlang);
    });
});
</script>
@endpush
