@extends('layouts.admin')

@section('title', 'Kelola Kondimen')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.kondimen.create') }}" class="btn btn-brand">+ Tambah Kondimen</a>
</div>

<div class="card-menu p-4">
    <div class="table-responsive">
        <table class="table table-seblak align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Kondimen</th>
                    <th>Harga Tambahan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kondimens as $kondimen)
                    <tr>
                        <td><img src="{{ $kondimen->gambar_url }}" width="48" height="48" style="object-fit:cover;border-radius:10px;" alt="{{ $kondimen->nama_kondimen }}"></td>
                        <td>{{ $kondimen->nama_kondimen }}</td>
                        <td>Rp {{ number_format($kondimen->harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($kondimen->status === 'aktif')
                                <span class="badge-status badge-lunas">Aktif</span>
                            @else
                                <span class="badge-status badge-dibatalkan">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.kondimen.edit', $kondimen) }}" class="btn btn-sm btn-outline-brand">Edit</a>
                                <form action="{{ route('admin.kondimen.destroy', $kondimen) }}" method="POST" onsubmit="return confirm('Hapus kondimen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-brand">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted-brand py-4">Belum ada kondimen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $kondimens->links() }}
    </div>
</div>
@endsection
