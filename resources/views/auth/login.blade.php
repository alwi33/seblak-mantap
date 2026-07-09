@extends('layouts.app')

@section('title','Login')

@section('content')
<div class="min-h-screen flex">
  <div class="w-1/2 hidden md:flex items-center justify-center bg-gradient-to-br from-primary to-secondary text-white p-12">
    <div>
      <h2 class="text-4xl font-bold">Selamat Datang</h2>
      <p class="mt-4">Silakan login untuk melanjutkan.</p>
    </div>
  </div>

  <div class="flex-1 flex items-center justify-center p-8">
    <div class="w-full max-w-md card-modern p-8">
      @if(session('success'))<div class="mb-3 text-green-700">{{ session('success') }}</div>@endif
      <form method="POST" action="{{ route('customer.login.submit') }}">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Email</label>
          <div class="flex items-center gap-2">
            <span class="text-gray-400">📧</span>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-3 rounded-xl border">
          </div>
          @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Password</label>
          <div class="flex items-center gap-2">
            <span class="text-gray-400">🔒</span>
            <input type="password" name="password" required class="w-full p-3 rounded-xl border">
          </div>
          @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="flex items-center justify-between mb-4">
          <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Remember Me</label>
        </div>

        <div class="mb-4">
          <button class="w-full btn-primary">Login</button>
        </div>
        <div class="text-center text-sm">Belum punya akun? <a href="{{ route('customer.register') }}" class="text-primary">Daftar</a></div>
      </form>
    </div>
  </div>
</div>
@endsection
