@extends('layouts.app')

@section('title')
    Profile: {{ $user->username }}
@endsection


@section('content')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <img src="{{ asset('img/user.svg') }}" alt="User defaul image">
            </div>

            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">
                <p class="text-gray-700 text-2xl">{{ $user->username }}</p>

                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    0
                    <span class="font-normal">Followers</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    0
                    <span class="font-normal">Following</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    1
                    <span class="font-normal">Posts</span>
                </p>
            </div>
        </div>
    </div>

    <section>
        <h2 class="text-4xl text-center font-black my-10">Publications</h2>

        @if ($posts->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($posts as $post)
                    <div class="">
                    {{-- x el route model binding necesita el post, o solo el id --}}
                    {{-- <a href="{{ route('posts.show', ['user'=>$user, 'post'=>$post]) }}"> --}}
                        <a href="{{ route('posts.show', [$user->username, $post]) }}">
                            <img src="{{ asset('uploads') . '/' . $post->image }}" alt="Post image | {{ $post->title }}">
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="my-10">
                {{-- laravel ya mete la logica de la paginacion | defaul pagining with tailwindcss styles --}}
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-center">No Posts</p>
        @endif
    </section>
@endsection
