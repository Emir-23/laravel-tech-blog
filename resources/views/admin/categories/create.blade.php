@extends('layouts.admin')

@section('title', 'Yeni kategori')
@section('heading', 'Yeni kategori')

@section('content')
    @include('admin.categories._form', ['category' => null])
@endsection
