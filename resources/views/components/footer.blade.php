@php
    $pengaturanFooter = \App\Models\Pengaturan::aktif();
    $inisial = \Illuminate\Support\Str::of($pengaturanFooter->nama_toko)->explode(' ')->map(fn($w) => mb_substr($w,0,1))->join('');
@endphp
<footer id="kontak-footer" class="mt-16 bg-gradient-to-b from-white/50 to-gray-50 border-t border-gray-200 py-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <!-- Main Footer Content -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
      <!-- Column 1: Tentang Toko -->
      <div class="space-y-4">
        <div class="flex items-center gap-3">
          @if ($pengaturanFooter->logo_url)
            <img src="{{ $pengaturanFooter->logo_url }}" alt="{{ $pengaturanFooter->nama_toko }}" class="w-12 h-12 rounded-2xl object-cover">
          @else
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-sm">{{ $inisial }}</div>
          @endif
          <div>
            <div class="font-bold text-lg">{{ $pengaturanFooter->nama_toko }}</div>
            <div class="text-xs text-gray-600">Pedasnya Bikin Nagih</div>
          </div>
        </div>
        <p class="text-sm text-gray-600">{{ $pengaturanFooter->alamat_toko ?: 'Alamat toko akan tampil di sini setelah diisi lewat panel admin.' }}</p>
      </div>

      <!-- Column 2: Menu Cepat -->
      <div class="space-y-3">
        <h4 class="font-semibold text-gray-900 mb-3">Menu Cepat</h4>
        <ul class="space-y-2">
          <li><a href="{{ route('menu.index') }}" class="text-sm text-gray-600 hover:text-primary transition">🍜 Lihat Menu</a></li>
          <li><a href="{{ route('keranjang.index') }}" class="text-sm text-gray-600 hover:text-primary transition">🛒 Keranjang</a></li>
          <li><a href="{{ route('status.form') }}" class="text-sm text-gray-600 hover:text-primary transition">🧾 Cek Status Pesanan</a></li>
          @auth
            <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-primary transition">📱 Akun Saya</a></li>
          @endauth
        </ul>
      </div>

      <!-- Column 3: Info Kontak -->
      <div class="space-y-3">
        <h4 class="font-semibold text-gray-900 mb-3">Hubungi Kami</h4>
        <ul class="space-y-2">
          @if ($pengaturanFooter->no_wa)
            <li>
              <a href="https://wa.me/{{ preg_replace('/\D/', '', $pengaturanFooter->no_wa) }}" target="_blank" class="text-sm text-gray-600 hover:text-primary transition flex items-center gap-2">
                📱 {{ $pengaturanFooter->no_wa }}
              </a>
            </li>
          @else
            <li><span class="text-sm text-gray-500">Nomor WhatsApp belum diatur</span></li>
          @endif
          @if ($pengaturanFooter->nama_toko)
            <li>
              <a href="#" class="text-sm text-gray-600 hover:text-primary transition flex items-center gap-2">
                📍 {{ $pengaturanFooter->alamat_toko ?: 'Lokasi toko' }}
              </a>
            </li>
          @endif
        </ul>
      </div>

      <!-- Column 4: Info Penting -->
      <div class="space-y-3">
        <h4 class="font-semibold text-gray-900 mb-3">Info Penting</h4>
        <ul class="space-y-2">
          <li><a href="#about" class="text-sm text-gray-600 hover:text-primary transition">ℹ️ Tentang Kami</a></li>
          <li><a href="#menu-list" class="text-sm text-gray-600 hover:text-primary transition">🎯 Promo Spesial</a></li>
          @guest
            <li><a href="{{ route('customer.login') }}" class="text-sm text-gray-600 hover:text-primary transition">🔓 Login</a></li>
            <li><a href="{{ route('customer.register') }}" class="text-sm text-gray-600 hover:text-primary transition">📝 Daftar Akun</a></li>
          @endguest
        </ul>
      </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-gray-200 pt-8"></div>

    <!-- Bottom Footer -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-600">
      <p>&copy; {{ date('Y') }} <strong>{{ $pengaturanFooter->nama_toko }}</strong>. Semua hak cipta dilindungi.</p>
      <div class="flex gap-4">
        <a href="{{ route('menu.index') }}" class="hover:text-primary transition">Halaman Utama</a>
        <a href="{{ route('status.form') }}" class="hover:text-primary transition">Cek Pesanan</a>
        @if ($pengaturanFooter->no_wa)
          <a href="https://wa.me/{{ preg_replace('/\D/', '', $pengaturanFooter->no_wa) }}" target="_blank" class="hover:text-primary transition">Hubungi WA</a>
        @endif
      </div>
    </div>
  </div>
</footer>
