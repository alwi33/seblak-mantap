@php
    $kondimens = $kondimens ?? collect();
@endphp
<div class="card-modern p-4 transition-smooth menu-card">
    <div class="h-48 overflow-hidden rounded-xl">
        <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover">
    </div>
    <div class="mt-3">
        <div class="flex justify-between items-center">
            <h3 class="font-semibold">{{ $paket->nama_paket }}</h3>
            <div class="text-primary font-bold">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
        </div>
        <p class="text-sm text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($paket->deskripsi, 80) }}</p>

        <details class="mt-4 group">
            <summary class="list-none cursor-pointer flex items-center justify-between px-4 py-2 rounded-xl border border-primary text-primary font-semibold text-sm">
                <span>Pilih &amp; Racik Sendiri</span>
                <span class="transition-transform group-open:rotate-180">⌄</span>
            </summary>

            <form action="{{ route('keranjang.tambah') }}" method="POST" class="mt-3 space-y-3" data-paket-card data-harga-paket="{{ (float) $paket->harga }}">
                @csrf
                <input type="hidden" name="paket_id" value="{{ $paket->id }}">

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jumlah</label>
                    <input type="number" name="jumlah" value="1" min="1" max="20" class="w-full p-2 rounded-xl border input-jumlah" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Level Pedas</label>
                    <div class="pedas-rating flex flex-row-reverse justify-end gap-1">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" name="tingkat_pedas" value="{{ $i }}" id="pedas-{{ $paket->id }}-{{ $i }}" {{ $i == 1 ? 'checked' : '' }}>
                            <label for="pedas-{{ $paket->id }}-{{ $i }}" title="Level {{ $i }}">🌶️</label>
                        @endfor
                    </div>
                </div>

                @if ($kondimens->isNotEmpty())
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tambah Kondimen</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($kondimens as $kondimen)
                                <div class="kondimen-chip">
                                    <input type="checkbox" name="kondimen[]" value="{{ $kondimen->id }}"
                                           id="kondimen-{{ $paket->id }}-{{ $kondimen->id }}"
                                           class="input-kondimen" data-harga="{{ (float) $kondimen->harga }}">
                                    <label for="kondimen-{{ $paket->id }}-{{ $kondimen->id }}">
                                        {{ $kondimen->nama_kondimen }} (+{{ number_format($kondimen->harga, 0, ',', '.') }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between pt-1">
                    <span class="text-xs text-gray-500">Total: <strong class="live-total text-primary">Rp {{ number_format($paket->harga, 0, ',', '.') }}</strong></span>
                    <button type="submit" class="btn-primary text-sm px-4 py-2">+ Keranjang</button>
                </div>
            </form>
        </details>
    </div>
</div>
