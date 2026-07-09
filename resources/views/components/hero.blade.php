@php
    $pengaturanHero = \App\Models\Pengaturan::aktif();
    $hargaMulai = $pakets->min('harga');
    $produkHero = $pakets->take(3);
@endphp

<section id="hero" class="relative overflow-hidden pt-28 pb-14 bg-bg hero-grid-bg">
    <div class="relative max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-12 items-center">
            {{-- Kolom promo (kiri) --}}
            <div class="animate-on-scroll">
                <div class="inline-block bg-accent px-5 py-3 rounded-xl shadow-modern -rotate-1">
                    <span class="block text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">PEDAS ANTI RIBET</span>
                </div>
                <div class="mt-2">
                    <span class="block text-3xl sm:text-4xl md:text-5xl font-extrabold text-primary leading-tight">HARGA IRIT!</span>
                </div>

                @if ($hargaMulai)
                    <div class="mt-6 inline-flex flex-col items-start bg-white border-2 border-dashed border-secondary rounded-2xl px-5 py-3 shadow-modern rotate-1">
                        <span class="text-xs font-semibold text-gray-500">MULAI DARI</span>
                        <span class="text-2xl font-extrabold text-secondary">Rp {{ number_format($hargaMulai, 0, ',', '.') }}</span>
                    </div>
                @endif

                <p class="mt-6 text-sm text-gray-500 max-w-sm">*S&amp;K berlaku. Harga belum termasuk ongkir. {{ $pengaturanHero->nama_toko }}.</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#menu-list" class="btn-primary">Pesan Sekarang</a>
                    <a href="#menu-list" class="px-5 py-3 rounded-2xl border border-primary text-primary font-semibold transition-smooth hover:bg-primary hover:text-white">Lihat Menu</a>
                </div>
            </div>

            {{-- Kolom foto produk (kanan) - style ala "MY BOX" Pizza Hut:
                 kotak foto + label pill di bawahnya. Otomatis ambil dari
                 paket aktif, jadi begitu foto diunggah lewat admin (atau
                 ditaruh manual di storage/app/public/pakets), langsung
                 tampil di sini juga. --}}
            <div class="flex gap-4 sm:gap-6 justify-center md:justify-end flex-wrap animate-on-scroll">
                @forelse ($produkHero as $produk)
                    <div class="relative w-36 sm:w-44">
                        <div class="rounded-2xl overflow-hidden shadow-modern bg-white aspect-square border border-black/5">
                            <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_paket }}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div class="absolute left-1/2 -translate-x-1/2 -bottom-4 bg-white border-2 border-primary text-primary text-[11px] sm:text-xs font-bold px-3 sm:px-4 py-1.5 rounded-full whitespace-nowrap shadow-modern">
                            {{ strtoupper($produk->nama_paket) }}
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500 border border-dashed rounded-2xl p-6 text-center max-w-xs">
                        Foto paket seblak akan tampil di sini otomatis setelah kamu tambahkan menu lewat panel admin.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Strip fitur, ala Delivery/Takeaway/Party di referensi --}}
        <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="flex items-center gap-3 border rounded-xl px-5 py-4 bg-white/70 transition-smooth hover:shadow-modern">
                <span class="text-2xl">🛵</span><span class="font-semibold">Delivery</span>
            </div>
            <div class="flex items-center gap-3 border rounded-xl px-5 py-4 bg-white/70 transition-smooth hover:shadow-modern">
                <span class="text-2xl">🥡</span><span class="font-semibold">Bawa Pulang</span>
            </div>
            <div class="flex items-center gap-3 border rounded-xl px-5 py-4 bg-white/70 transition-smooth hover:shadow-modern">
                <span class="text-2xl">🍽️</span><span class="font-semibold">Makan di Tempat</span>
            </div>
        </div>
    </div>
</section>
