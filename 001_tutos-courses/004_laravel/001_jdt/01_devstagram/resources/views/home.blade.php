<!-- usar 1 layout -->
@extends('layouts.app')


<!-- Inyectar contenido en el template del q extendemos -->
@section('title')
    Home
@endsection


@section('content')
    {{-- components --}}
    {{-- en esta view recivimos $posts, debemos pasarsela al component > PostList.php --}}
    <x-post-list :posts="$posts" />
@endsection
