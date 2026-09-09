@extends('layouts.admin')

@section('title', 'Kategori düzenle')
@section('heading', 'Kategori düzenle')

@section('content')
    @include('admin.categories._form', ['category' => $category])
@endsection
