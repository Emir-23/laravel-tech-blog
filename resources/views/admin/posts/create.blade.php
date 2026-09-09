@extends('layouts.admin')

@section('title', 'Yeni yazı')
@section('heading', 'Yeni yazı')

@section('content')
    @include('admin.posts._form', ['post' => null, 'categories' => $categories])
@endsection
