@extends('layouts.admin')

@section('title', 'Edit Paket Seblak')

@section('content')
<div class="card-menu p-4">
    <form action="{{ route('admin.paket.update', $paket) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.paket._form')
    </form>
</div>
@endsection
