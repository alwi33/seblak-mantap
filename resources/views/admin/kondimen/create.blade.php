@extends('layouts.admin')

@section('title', 'Tambah Kondimen')

@section('content')
<div class="card-menu p-4">
    <form action="{{ route('admin.kondimen.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.kondimen._form')
    </form>
</div>
@endsection
