@php
    $pengaturanNav = \App\Models\Pengaturan::aktif();
    $keranjang = session('keranjang', []);
    $jumlahItem = count($keranjang);
    $isAdmin = auth()->check() && auth()->user()->is_admin;
@endphp
<nav class="site-nav fixed w-full z-40 top-0 left-0 transition-smooth bg-white/90 backdrop-blur-xl border-b border-white/60">
  <div class="h-[3px] w-full bg-gradient-to-r from-primary via-secondary to-accent"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="flex items-center justify-between h-16">
      <div class="flex items-center gap-3">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
          @if ($pengaturanNav->logo_url)
            <img src="{{ $pengaturanNav->logo_url }}" alt="{{ $pengaturanNav->nama_toko }}" class="w-12 h-12 rounded-2xl object-cover shadow-modern ring-2 ring-white transition-transform group-hover:scale-105">
          @else
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold shadow-modern ring-2 ring-white transition-transform group-hover:scale-105">
              {{ \Illuminate\Support\Str::of($pengaturanNav->nama_toko)->explode(' ')->map(fn($w) => mb_substr($w,0,1))->join('') }}
            </div>
          @endif
          <div class="hidden md:block">
            <div class="font-bold text-lg leading-tight group-hover:text-primary transition-colors">{{ $pengaturanNav->nama_toko }}</div>
            <div class="text-xs text-gray-500">Pedasnya Bikin Nagih</div>
          </div>
        </a>
      </div>

      <div class="hidden md:flex items-center gap-1">
        @if (!$isAdmin)
          <!-- Menu Pelanggan -->
          <div class="flex items-center gap-1 mr-3">
            <a href="#hero" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">Home</a>
            <a href="#menu-list" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">Menu</a>
            <a href="#promo" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">Promo</a>
            <a href="#about" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">Tentang</a>
            <a href="#kontak" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">Kontak</a>
          </div>

          <a href="{{ route('keranjang.index') }}" class="relative p-2.5 rounded-full hover:bg-black/5 transition-colors" aria-label="Keranjang">
            <span class="text-xl">🛒</span>
            @if ($jumlahItem > 0)
              <span class="absolute top-0 right-0 inline-flex h-5 w-5 -translate-y-1/3 translate-x-1/3 items-center justify-center">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary/60"></span>
                <span class="relative inline-flex items-center justify-center h-5 w-5 rounded-full bg-primary text-white text-[11px] font-bold leading-none">
                  {{ $jumlahItem }}
                </span>
              </span>
            @endif
          </a>

          @guest
            <a href="{{ route('customer.login') }}" class="ml-2 px-4 py-2 rounded-full border-2 border-primary text-primary text-sm font-semibold hover:bg-primary hover:text-white transition-smooth">Login</a>
            <a href="{{ route('customer.register') }}" class="ml-2 px-4 py-2 rounded-full bg-gradient-to-r from-primary to-secondary text-white text-sm font-semibold shadow-modern hover:shadow-glow hover:-translate-y-0.5 transition-smooth">Daftar</a>
          @else
            <div class="flex items-center gap-2 ml-2">
              <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-full border border-primary/20 hover:bg-primary/5 transition-colors"> Akun</a>
              <form method="POST" action="{{ route('customer.logout') }}" class="inline">
                @csrf
                <button class="px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-semibold hover:bg-primary/20 transition-colors">Logout</button>
              </form>
            </div>
          @endguest
        @else
          <!-- Menu Admin -->
          <div class="flex items-center gap-1 mr-3">
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">📊 Dashboard</a>
            <a href="{{ route('admin.paket.index') }}" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">🍜 Paket</a>
            <a href="{{ route('admin.kondimen.index') }}" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">🧂 Kondimen</a>
            <a href="{{ route('admin.pemesanan.index') }}" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">🧾 Pesanan</a>
            <a href="{{ route('admin.pengaturan.edit') }}" class="px-3 py-2 rounded-full text-sm font-medium hover:bg-primary/5 hover:text-primary transition-colors">⚙️ Pengaturan</a>
          </div>
          <a href="{{ route('menu.index') }}" target="_blank" class="px-3 py-2 text-sm font-medium rounded-full border border-primary/20 hover:bg-primary/5 transition-colors">👁️ Lihat Toko</a>
          <form method="POST" action="{{ route('admin.logout') }}" class="inline ml-2">
            @csrf
            <button class="px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-semibold hover:bg-primary/20 transition-colors">Logout</button>
          </form>
        @endif
      </div>

      <div class="md:hidden">
        <button id="mobile-menu-btn" class="p-2.5 rounded-xl bg-white/80 backdrop-blur text-text shadow-sm border border-black/5" aria-expanded="false" aria-controls="mobile-menu-panel">
          <span aria-hidden="true" class="text-lg">☰</span>
          <span class="sr-only">Buka menu</span>
        </button>
      </div>
    </div>

    <div id="mobile-menu-panel" class="md:hidden hidden pb-5">
      <div class="flex flex-col gap-1 pt-3 mt-1 border-t border-gray-100">
        @if (!$isAdmin)
          <!-- Mobile Menu Pelanggan -->
          <a href="#hero" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors"> Home</a>
          <a href="#menu-list" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors"> Menu</a>
          <a href="#promo" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors"Promo</a>
          <a href="#about" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors"> Tentang</a>
          <a href="#kontak" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors"> Kontak</a>
          <a href="{{ route('keranjang.index') }}" class="relative px-3 py-2.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-colors flex items-center gap-2 font-medium">
            <span>🛒 Keranjang</span>
            @if ($jumlahItem > 0)
              <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-primary rounded-full">
                {{ $jumlahItem }}
              </span>
            @endif
          </a>
          @guest
            <div class="grid grid-cols-2 gap-2 mt-3">
              <a href="{{ route('customer.login') }}" class="text-center px-4 py-2.5 rounded-xl border-2 border-primary text-primary font-semibold">Login</a>
              <a href="{{ route('customer.register') }}" class="text-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-primary to-secondary text-white font-semibold shadow-modern">Daftar</a>
            </div>
          @else
            <a href="{{ route('dashboard') }}" class="mt-3 text-center px-4 py-2.5 rounded-xl border-2 border-primary text-primary font-semibold"> Akun Saya</a>
            <form method="POST" action="{{ route('customer.logout') }}" class="mt-2">@csrf<button class="w-full px-4 py-2.5 rounded-xl bg-primary text-white font-semibold">Logout</button></form>
          @endguest
        @else
          <!-- Mobile Menu Admin -->
          <a href="{{ route('admin.dashboard') }}" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors">📊 Dashboard</a>
          <a href="{{ route('admin.paket.index') }}" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors">🍜 Paket Seblak</a>
          <a href="{{ route('admin.kondimen.index') }}" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors">🧂 Kondimen</a>
          <a href="{{ route('admin.pemesanan.index') }}" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors">🧾 Pesanan Masuk</a>
          <a href="{{ route('admin.pengaturan.edit') }}" class="px-3 py-2.5 rounded-xl font-medium hover:bg-primary/5 hover:text-primary transition-colors">⚙️ Pengaturan</a>
          <a href="{{ route('menu.index') }}" target="_blank" class="mt-3 text-center px-4 py-2.5 rounded-xl border-2 border-primary text-primary font-semibold">👁️ Lihat Halaman Toko</a>
          <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">@csrf<button class="w-full px-4 py-2.5 rounded-xl bg-primary text-white font-semibold">Logout</button></form>
        @endif
      </div>
    </div>
  </div>
</nav>