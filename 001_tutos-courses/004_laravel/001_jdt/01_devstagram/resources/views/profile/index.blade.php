@extends('layouts.app')

@section('title')
    Edit Profile: {{ auth()->user()->username }}
@endsection


@section('content')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            {{-- enctype for files --}}
            <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500">
                        Username
                    </label>
                    <input type="text" id="username" name="username" placeholder="Your username"
                        value="{{ auth()->user()->username }}"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror">
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="image" class="mb-2 block uppercase text-gray-500">
                        Profile image
                    </label>
                    <input type="file" id="image" name="image"
                        class="border p-3 w-full rounded-lg @error('image') border-red-500 @enderror"
                        accept=".jpg, .jpeg, .png, .svg">
                </div>

                <input type="submit" value="Save Changes"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection
