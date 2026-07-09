@extends('layouts.admin')

@section('title', 'Tambah Paket Seblak')

@section('content')
<div class="card-menu p-4">
    <form action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.paket._form')
    </form>
</div>
@endsection
