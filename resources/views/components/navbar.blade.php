@php
    $pengaturanNav = \App\Models\Pengaturan::aktif();
    $keranjang = session('keranjang', []);
    $jumlahItem = count($keranjang);
    $isAdmin = auth()->check() && auth()->user()->is_admin;
@endphp
<nav class="site-nav fixed w-full z-40 top-0 left-0 transition-smooth bg-white/90 backdrop-blur-xl border-b border-white/60">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="flex items-center justify-between h-16">
      <div class="flex items-center gap-3">
        <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition">
          @if ($pengaturanNav->logo_url)
            <img src="{{ $pengaturanNav->logo_url }}" alt="{{ $pengaturanNav->nama_toko }}" class="w-12 h-12 rounded-2xl object-cover">
          @else
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold">
              {{ \Illuminate\Support\Str::of($pengaturanNav->nama_toko)->explode(' ')->map(fn($w) => mb_substr($w,0,1))->join('') }}
            </div>
          @endif
          <div class="hidden md:block">
            <div class="font-bold text-lg">{{ $pengaturanNav->nama_toko }}</div>
            <div class="text-xs text-gray-600">Pedasnya Bikin Nagih</div>
          </div>
        </a>
      </div>

      <div class="hidden md:flex items-center gap-6">
        @if (!$isAdmin)
          <!-- Menu Pelanggan -->
          <a href="#hero" class="hover:underline decoration-primary decoration-2 underline-offset-4">Home</a>
          <a href="#menu-list" class="hover:underline">Menu</a>
          <a href="#promo" class="hover:underline">Promo</a>
          <a href="#about" class="hover:underline">Tentang</a>
          <a href="#kontak" class="hover:underline">Kontak</a>
          <a href="{{ route('keranjang.index') }}" class="relative p-2 rounded-full hover:bg-black/5 transition-colors">
            <span class="text-xl">🛒</span>
            @if ($jumlahItem > 0)
              <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-primary rounded-full">
                {{ $jumlahItem }}
              </span>
            @endif
          </a>
          @guest
            <a href="{{ route('customer.login') }}" class="px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary/5">Login</a>
            <a href="{{ route('customer.register') }}" class="px-4 py-2 rounded-full bg-primary text-white hover:opacity-90">Daftar</a>
          @else
            <div class="flex items-center gap-3">
              <a href="{{ route('dashboard') }}" class="px-3 py-1 text-sm rounded-full border border-primary/20 hover:bg-primary/5">📱 Akun</a>
              <form method="POST" action="{{ route('customer.logout') }}" class="inline">
                @csrf
                <button class="px-4 py-2 rounded-full bg-primary/10 text-primary hover:bg-primary/20">Logout</button>
              </form>
            </div>
          @endguest
        @else
          <!-- Menu Admin -->
          <a href="{{ route('admin.dashboard') }}" class="hover:underline"> Dashboard</a>
          <a href="{{ route('admin.paket.index') }}" class="hover:underline">Paket</a>
          <a href="{{ route('admin.kondimen.index') }}" class="hover:underline">Kondimen</a>
          <a href="{{ route('admin.pemesanan.index') }}" class="hover:underline">Pesanan</a>
          <a href="{{ route('admin.pengaturan.edit') }}" class="hover:underline">⚙️ Pengaturan</a>
          <a href="{{ route('menu.index') }}" target="_blank" class="px-3 py-1 text-sm rounded-full border border-primary/20 hover:bg-primary/5">👁️ Lihat Toko</a>
          <form method="POST" action="{{ route('admin.logout') }}" class="inline">
            @csrf
            <button class="px-4 py-2 rounded-full bg-primary/10 text-primary hover:bg-primary/20">Logout</button>
          </form>
        @endif
      </div>

      <div class="md:hidden">
        <button id="mobile-menu-btn" class="p-2 rounded-md bg-white/80 backdrop-blur text-text" aria-expanded="false" aria-controls="mobile-menu-panel">
          <span aria-hidden="true">☰</span>
          <span class="sr-only">Buka menu</span>
        </button>
      </div>
    </div>

    <div id="mobile-menu-panel" class="md:hidden hidden pb-4">
      <div class="flex flex-col gap-1 pt-2 border-t">
        @if (!$isAdmin)
          <!-- Mobile Menu Pelanggan -->
          <a href="#hero" class="px-2 py-2 rounded-lg hover:bg-black/5">Home</a>
          <a href="#menu-list" class="px-2 py-2 rounded-lg hover:bg-black/5">Menu</a>
          <a href="#promo" class="px-2 py-2 rounded-lg hover:bg-black/5">Promo</a>
          <a href="#about" class="px-2 py-2 rounded-lg hover:bg-black/5">Tentang</a>
          <a href="#kontak" class="px-2 py-2 rounded-lg hover:bg-black/5">Kontak</a>
          <a href="{{ route('keranjang.index') }}" class="relative px-2 py-2 rounded-lg hover:bg-black/5 flex items-center gap-2">
            <span class="text-lg">🛒 Keranjang</span>
            @if ($jumlahItem > 0)
              <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-primary rounded-full">
                {{ $jumlahItem }}
              </span>
            @endif
          </a>
          @guest
            <a href="{{ route('customer.login') }}" class="mt-2 text-center px-4 py-2 rounded-full border border-primary text-primary">Login</a>
            <a href="{{ route('customer.register') }}" class="mt-2 text-center px-4 py-2 rounded-full bg-primary text-white">Daftar</a>
          @else
            <a href="{{ route('dashboard') }}" class="mt-2 text-center px-4 py-2 rounded-full border border-primary text-primary">📱 Akun Saya</a>
            <form method="POST" action="{{ route('customer.logout') }}" class="mt-2">@csrf<button class="w-full px-4 py-2 rounded-full bg-primary text-white">Logout</button></form>
          @endguest
        @else
          <!-- Mobile Menu Admin -->
          <a href="{{ route('admin.dashboard') }}" class="px-2 py-2 rounded-lg hover:bg-black/5">📊 Dashboard</a>
          <a href="{{ route('admin.paket.index') }}" class="px-2 py-2 rounded-lg hover:bg-black/5">🍜 Paket Seblak</a>
          <a href="{{ route('admin.kondimen.index') }}" class="px-2 py-2 rounded-lg hover:bg-black/5">🧂 Kondimen</a>
          <a href="{{ route('admin.pemesanan.index') }}" class="px-2 py-2 rounded-lg hover:bg-black/5">🧾 Pesanan Masuk</a>
          <a href="{{ route('admin.pengaturan.edit') }}" class="px-2 py-2 rounded-lg hover:bg-black/5">⚙️ Pengaturan</a>
          <a href="{{ route('menu.index') }}" target="_blank" class="mt-2 text-center px-4 py-2 rounded-full border border-primary text-primary">👁️ Lihat Halaman Toko</a>
          <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">@csrf<button class="w-full px-4 py-2 rounded-full bg-primary text-white">Logout</button></form>
        @endif
      </div>
    </div>
  </div>
</nav>
