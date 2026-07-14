<div class="brand">
    <span>🌶️</span>
    <span>Seblak Mantap</span>
</div>

<nav class="nav flex-column">
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        Dashboard
    </a>
    <a class="nav-link {{ request()->routeIs('admin.paket.*') ? 'active' : '' }}" href="{{ route('admin.paket.index') }}">
         Kelola Paket Seblak
    </a>
    <a class="nav-link {{ request()->routeIs('admin.kondimen.*') ? 'active' : '' }}" href="{{ route('admin.kondimen.index') }}">
         Kelola Kondimen
    </a>
    <a class="nav-link {{ request()->routeIs('admin.pemesanan.*') ? 'active' : '' }}" href="{{ route('admin.pemesanan.index') }}">
         Pesanan Masuk
    </a>
    <a class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}" href="{{ route('admin.pengaturan.edit') }}">
         Pengaturan Toko
    </a>
    <hr class="border-secondary">
    <a class="nav-link" href="{{ route('menu.index') }}" target="_blank">
         Lihat Halaman Pelanggan
    </a>
</nav>
