@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="max-w-7xl mx-auto p-6">
  <div class="flex gap-6">
    <aside class="w-64 card-modern p-4">
      <div class="font-semibold">Menu</div>
      <ul class="mt-4 space-y-2 text-sm text-gray-700">
        <li><a href="{{ route('dashboard') }}" class="text-primary">Dashboard</a></li>
        <li><a href="{{ route('status.form') }}">Cek Pesanan</a></li>
      </ul>
    </aside>

    <div class="flex-1">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="card-modern p-4">Total Pesanan<br><div class="text-2xl font-bold">0</div></div>
        <div class="card-modern p-4">Pendapatan<br><div class="text-2xl font-bold">Rp 0</div></div>
        <div class="card-modern p-4">Status<br><div class="text-2xl font-bold">Aktif</div></div>
      </div>

      <div class="card-modern p-6">
        <h3 class="text-xl font-semibold">Selamat Datang, {{ $user->name }}</h3>
        <p class="text-sm text-gray-600 mt-2">Semoga harimu menyenangkan. Ini adalah dashboard sederhana.</p>
      </div>
    </div>
  </div>
</div>
@endsection
