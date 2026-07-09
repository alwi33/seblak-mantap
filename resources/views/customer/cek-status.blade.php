@extends('layouts.app')

@section('title', 'Cek Status Pesanan')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-center">
            <div class="w-full max-w-md card-modern p-6">
                <h4 class="text-xl font-bold text-primary mb-3">Cek Status Pesanan</h4>
                <p class="text-sm text-gray-600 mb-4">Masukkan kode pesanan (contoh: SBK-20260707-AB12) atau nomor HP yang kamu gunakan saat memesan.</p>
                <form action="{{ route('status.cek') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="text" name="cari" value="{{ old('cari') }}" class="w-full p-3 rounded-xl border" placeholder="Kode pesanan atau no. HP" required>
                    <button type="submit" class="btn-primary w-full justify-center">Cek Status</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
