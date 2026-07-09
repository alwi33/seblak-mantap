@extends('layouts.app')

@section('title','Register')

@section('content')
<div class="min-h-screen flex">
  <div class="w-1/2 hidden md:flex items-center justify-center bg-gradient-to-br from-primary to-secondary text-white p-12">
    <div>
      <h2 class="text-4xl font-bold">Daftar Akun</h2>
      <p class="mt-4">Buat akun untuk memesan lebih cepat.</p>
    </div>
  </div>

  <div class="flex-1 flex items-center justify-center p-8">
    <div class="w-full max-w-md card-modern p-8">
      <form method="POST" action="{{ route('customer.register.submit') }}">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Nama</label>
          <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-3 rounded-xl border">
          @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-3 rounded-xl border">
          @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4 grid grid-cols-2 gap-3">
          <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required class="w-full p-3 rounded-xl border">
            @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Konfirmasi</label>
            <input type="password" name="password_confirmation" required class="w-full p-3 rounded-xl border">
          </div>
        </div>

        <div class="mb-4">
          <button class="w-full btn-primary">Daftar</button>
        </div>
        <div class="text-center text-sm">Sudah punya akun? <a href="{{ route('customer.login') }}" class="text-primary">Login</a></div>
      </form>
    </div>
  </div>
</div>
@endsection
