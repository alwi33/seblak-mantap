@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-8">Keranjang Kamu</h2>

        @if (empty($items))
            <div class="card-modern text-center py-16 px-6">
                <div class="text-5xl mb-3">🛒</div>
                <p class="text-gray-600 mb-4">Keranjang kamu masih kosong. Yuk pilih seblak favoritmu dulu!</p>
                <a href="{{ route('menu.index') }}" class="btn-primary inline-flex">Lihat Menu</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <div class="lg:col-span-3 space-y-4">
                    @foreach ($items as $item)
                        <div class="card-modern p-4">
                            <div class="flex justify-between items-start gap-3 flex-wrap">
                                <div>
                                    <h5 class="font-semibold">{{ $item['nama_paket'] }}</h5>
                                    <p class="text-sm text-gray-500 mt-1">Level pedas: {{ str_repeat('🌶️', (int) $item['tingkat_pedas']) }}</p>
                                    @if (!empty($item['kondimen']))
                                        <p class="text-sm text-gray-500">
                                            Kondimen: {{ collect($item['kondimen'])->pluck('nama')->join(', ') }}
                                        </p>
                                    @endif
                                    <p class="font-bold text-primary mt-1">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                                <form action="{{ route('keranjang.hapus', $item['id']) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-full border border-primary text-primary text-sm font-semibold">Hapus</button>
                                </form>
                            </div>
                            <form action="{{ route('keranjang.update', $item['id']) }}" method="POST" class="flex items-center gap-2 mt-3">
                                @csrf
                                <label class="text-sm text-gray-600">Jumlah:</label>
                                <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1" max="20" class="w-20 p-2 rounded-xl border text-sm">
                                <button type="submit" class="px-3 py-1.5 rounded-full border text-sm font-semibold">Perbarui</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="lg:col-span-2">
                    <div class="card-modern p-6">
                        <h5 class="text-xl font-bold text-primary mb-4">Total: Rp {{ number_format($total, 0, ',', '.') }}</h5>

                        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium mb-1">Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" class="w-full p-3 rounded-xl border" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">No. HP / WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full p-3 rounded-xl border" required placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Tipe Pesanan</label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" class="tipe-pesanan-radio" name="tipe_pesanan" value="bawa_pulang" {{ old('tipe_pesanan', 'bawa_pulang') == 'bawa_pulang' ? 'checked' : '' }}>
                                        Bawa Pulang
                                    </label>
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" class="tipe-pesanan-radio" name="tipe_pesanan" value="makan_di_tempat" {{ old('tipe_pesanan') == 'makan_di_tempat' ? 'checked' : '' }}>
                                        Makan di Tempat
                                    </label>
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" class="tipe-pesanan-radio" name="tipe_pesanan" value="delivery" {{ old('tipe_pesanan') == 'delivery' ? 'checked' : '' }}>
                                        Delivery
                                    </label>
                                </div>
                            </div>

                            <div id="field-meja" class="hidden">
                                <label class="block text-sm font-medium mb-1">Nomor Meja</label>
                                <input type="text" name="meja" value="{{ old('meja') }}" class="w-full p-3 rounded-xl border">
                            </div>

                            <div id="field-alamat" class="hidden">
                                <label class="block text-sm font-medium mb-1">Alamat Pengiriman</label>
                                <textarea name="alamat_pengiriman" class="w-full p-3 rounded-xl border" rows="2">{{ old('alamat_pengiriman') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Catatan (opsional)</label>
                                <textarea name="catatan" class="w-full p-3 rounded-xl border" rows="2" placeholder="Contoh: jangan pakai bawang">{{ old('catatan') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
                                <div class="flex flex-col gap-2">
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" name="metode_pembayaran" value="qris" {{ old('metode_pembayaran', 'qris') == 'qris' ? 'checked' : '' }}>
                                        QRIS
                                    </label>
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" name="metode_pembayaran" value="cash" {{ old('metode_pembayaran') == 'cash' ? 'checked' : '' }}>
                                        Tunai (bayar di tempat)
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary w-full justify-center">Buat Pesanan &amp; Bayar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
function toggleTipePesananFields() {
    const checked = document.querySelector('input[name="tipe_pesanan"]:checked');
    const fieldMeja = document.getElementById('field-meja');
    const fieldAlamat = document.getElementById('field-alamat');
    if (!checked || !fieldMeja || !fieldAlamat) return;

    fieldMeja.classList.toggle('hidden', checked.value !== 'makan_di_tempat');
    fieldAlamat.classList.toggle('hidden', checked.value !== 'delivery');
}

document.querySelectorAll('.tipe-pesanan-radio').forEach(function (radio) {
    radio.addEventListener('change', toggleTipePesananFields);
});
document.addEventListener('DOMContentLoaded', toggleTipePesananFields);
</script>
@endpush
