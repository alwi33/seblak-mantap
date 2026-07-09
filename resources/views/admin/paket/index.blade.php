@extends('layouts.admin')

@section('title', 'Kelola Paket Seblak')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.paket.create') }}" class="btn btn-brand">+ Tambah Paket</a>
</div>

<div class="card-menu p-4">
    <div class="table-responsive">
        <table class="table table-seblak align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Paket</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pakets as $paket)
                    <tr>
                        <td><img src="{{ $paket->gambar_url }}" width="56" height="56" style="object-fit:cover;border-radius:10px;" alt="{{ $paket->nama_paket }}"></td>
                        <td>{{ $paket->nama_paket }}</td>
                        <td>{{ ucfirst($paket->kategori) }}</td>
                        <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($paket->status === 'aktif')
                                <span class="badge-status badge-lunas">Aktif</span>
                            @else
                                <span class="badge-status badge-dibatalkan">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.paket.edit', $paket) }}" class="btn btn-sm btn-outline-brand">Edit</a>
                                <form action="{{ route('admin.paket.destroy', $paket) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-brand">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted-brand py-4">Belum ada paket seblak. Yuk tambahkan menu pertamamu!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $pakets->links() }}
    </div>
</div>
@endsection
