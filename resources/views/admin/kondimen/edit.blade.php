@extends('layouts.admin')

@section('title', 'Edit Kondimen')

@section('content')
<div class="card-menu p-4">
    <form action="{{ route('admin.kondimen.update', $kondimen) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.kondimen._form')
    </form>
</div>
@endsection
