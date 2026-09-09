@extends('layouts.admin')

@section('title', 'Yazı düzenle')
@section('heading', 'Yazı düzenle')

@section('content')
    @include('admin.posts._form', ['post' => $post, 'categories' => $categories])
@endsection
