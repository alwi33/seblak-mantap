@extends('layouts.app')

@section('title','Login')

@section('content')
<div class="min-h-screen flex">
  <div class="w-1/2 hidden md:flex relative items-center justify-center bg-gradient-to-br from-primary to-secondary text-white p-12 overflow-hidden">
    <div class="pointer-events-none absolute -top-16 -left-16 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>
    <div class="pointer-events-none absolute bottom-0 right-0 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
    <div class="pointer-events-none absolute inset-0 hero-grid-bg opacity-20"></div>
    <div class="relative">
      <span class="text-5xl">🌶️</span>
      <h2 class="mt-4 text-4xl font-bold leading-tight">Selamat Datang<br>Kembali</h2>
      <p class="mt-4 text-white/90 max-w-sm">Login untuk lanjut pesan seblak favoritmu dan pantau status pesananmu.</p>
    </div>
  </div>

  <div class="flex-1 flex items-center justify-center p-8">
    <div class="w-full max-w-md card-modern p-8 animate-on-scroll">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Login</h1>
        <p class="text-sm text-gray-500 mt-1">Masuk ke akunmu untuk melanjutkan.</p>
      </div>

      @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm border border-green-100">{{ session('success') }}</div>
      @endif

      <form method="POST" action="{{ route('customer.login.submit') }}">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1.5">Email</label>
          <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">📧</span>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-smooth">
          </div>
          @error('email')<div class="text-red-600 text-sm mt-1.5">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1.5">Password</label>
          <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">🔒</span>
            <input type="password" name="password" required
                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-smooth">
          </div>
          @error('password')<div class="text-red-600 text-sm mt-1.5">{{ $message }}</div>@enderror
        </div>

        <div class="flex items-center justify-between mb-5">
          <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary/30"> Remember Me
          </label>
        </div>

        <button class="w-full btn-primary justify-center hover:shadow-glow hover:-translate-y-0.5">Login</button>

        <div class="text-center text-sm mt-5 text-gray-600">
            Belum punya akun? <a href="{{ route('customer.register') }}" class="text-primary font-semibold hover:underline">Daftar</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection