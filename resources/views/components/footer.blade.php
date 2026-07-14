<footer id="kontak-footer" class="relative overflow-hidden mt-16 bg-slate-900 text-gray-300 border-t border-slate-700">

    <!-- Background Decoration -->
    <div class="absolute inset-0">
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-primary/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-secondary/20 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-800 via-slate-900 to-black"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 py-14">

        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- Tentang -->
            <div class="space-y-5">

                <div class="flex items-center gap-4">

                    @if ($pengaturanFooter->logo_url)
                        <img src="{{ $pengaturanFooter->logo_url }}"
                             class="w-14 h-14 rounded-2xl object-cover ring-2 ring-primary/40"
                             alt="{{ $pengaturanFooter->nama_toko }}">
                    @else
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center font-bold text-lg text-white shadow-lg">
                            {{ $inisial }}
                        </div>
                    @endif

                    <div>
                        <h3 class="font-bold text-white text-xl">
                            {{ $pengaturanFooter->nama_toko }}
                        </h3>

                        <p class="text-sm text-primary font-medium">
                            🌶 Pedasnya Bikin Nagih
                        </p>
                    </div>

                </div>

                <p class="text-sm leading-7 text-gray-400">
                    {{ $pengaturanFooter->alamat_toko ?: 'Alamat toko akan tampil setelah diatur melalui panel admin.' }}
                </p>

            </div>

            <!-- Menu -->
            <div>

                <h4 class="text-white font-semibold mb-5">
                    Menu Cepat
                </h4>

                <ul class="space-y-3">

                    <li>
                        <a href="{{ route('menu.index') }}" class="hover:text-primary duration-300">
                            🍜 Lihat Menu
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('keranjang.index') }}" class="hover:text-primary duration-300">
                            🛒 Keranjang
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('status.form') }}" class="hover:text-primary duration-300">
                            🧾 Cek Pesanan
                        </a>
                    </li>

                    @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-primary duration-300">
                            👤 Dashboard
                        </a>
                    </li>
                    @endauth

                </ul>

            </div>

            <!-- Kontak -->
            <div>

                <h4 class="text-white font-semibold mb-5">
                    Hubungi Kami
                </h4>

                <ul class="space-y-3">

                    @if($pengaturanFooter->no_wa)

                    <li>
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $pengaturanFooter->no_wa) }}"
                           target="_blank"
                           class="flex items-center gap-2 hover:text-primary duration-300">
                            📱 {{ $pengaturanFooter->no_wa }}
                        </a>
                    </li>

                    @endif

                    <li class="flex items-start gap-2">
                        📍
                        <span>
                            {{ $pengaturanFooter->alamat_toko ?: 'Lokasi toko' }}
                        </span>
                    </li>

                </ul>

            </div>

            <!-- Info -->
            <div>

                <h4 class="text-white font-semibold mb-5">
                    Informasi
                </h4>

                <ul class="space-y-3">

                    <li>
                        <a href="#about" class="hover:text-primary duration-300">
                            ℹ Tentang Kami
                        </a>
                    </li>

                    <li>
                        <a href="#menu-list" class="hover:text-primary duration-300">
                            🎉 Promo Hari Ini
                        </a>
                    </li>

                    @guest

                    <li>
                        <a href="{{ route('customer.login') }}" class="hover:text-primary duration-300">
                            🔑 Login
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('customer.register') }}" class="hover:text-primary duration-300">
                            📝 Daftar
                        </a>
                    </li>

                    @endguest

                </ul>

            </div>

        </div>

        <!-- Divider -->
        <div class="border-t border-slate-700 my-10"></div>

        <!-- Bottom -->
        <div class="flex flex-col lg:flex-row items-center justify-between gap-5">

            <p class="text-sm text-gray-400">
                © {{ date('Y') }}
                <span class="font-semibold text-white">
                    {{ $pengaturanFooter->nama_toko }}
                </span>
                • Semua Hak Cipta Dilindungi.
            </p>

            <div class="flex flex-wrap gap-6 text-sm">

                <a href="{{ route('menu.index') }}" class="hover:text-primary duration-300">
                    Beranda
                </a>

                <a href="{{ route('status.form') }}" class="hover:text-primary duration-300">
                    Cek Pesanan
                </a>

                @if($pengaturanFooter->no_wa)

                <a href="https://wa.me/{{ preg_replace('/\D/', '', $pengaturanFooter->no_wa) }}"
                   target="_blank"
                   class="hover:text-primary duration-300">
                    WhatsApp
                </a>

                @endif

            </div>

        </div>

    </div>

</footer>