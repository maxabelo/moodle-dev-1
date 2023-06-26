@extends('layouts.app')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->image }}" alt="Post image - {{ $post->title }}">

            <div class="p-3">
                <p>0 likes</p>
            </div>

            <div>
                {{-- x las relaciones entre DB y las convenciones en el name: --}}
                <p class="font-bold">{{ $post->user->username }}</p>
                <p class="text-sm text-gray-500">
                    {{-- gracias a Carbon de Laravel <- difference for humans --}}
                    {{ $post->created_at->diffForHumans() }}
                </p>
                <p class="mt-5">{{ $post->description }}</p>
            </div>


            {{-- it can only be deleted by its creator | delete is an spoofing method --}}
            @auth()
                @if ($post->user_id === auth()->user()->id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @method('DELETE')
                        @csrf

                        <input type="submit" value="Delete Post"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
                    </form>
                @endif
            @endauth

        </div>

        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">

                @auth
                    <p class="text-xl font-bold text-center mb-4">
                        Add a new comment
                    </p>

                    @if (session('success_message'))
                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('success_message') }}
                        </div>
                    @endif

                    <form action="{{ route('comments.store', [$user, $post]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comment" class="mb-2 block uppercase text-gray-500 font-bold">
                                Add a comment
                            </label>
                            <textarea id="comment" name="comment" placeholder="Add a new comment"
                                class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"></textarea>

                            @error('comment')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                            @enderror
                        </div>

                        <input type="submit" value="Comment"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
                    </form>
                @endauth


                {{-- comments vienen x la Relation de DB en el Model --}}
                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comments->count())
                        @foreach ($post->comments as $comment)
                            <div class="p-5 border-gray-300 border-b">
                                <a href="{{ route('posts.index', $comment->user) }}" class="font-bold">
                                    {{ $comment->user->username }}
                                </a>
                                <p>
                                    {{ $comment->comment }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No comments</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
