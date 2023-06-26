@extends('layouts.app')

@section('title')
    Log In
@endsection

@section('content')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/login.jpg') }}" alt="Login image">
        </div>

        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                @if (session('message'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ session('message') }}
                    </p>
                @endif

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500">
                        Email
                    </label>
                    <input type="email" id="email" name="email" placeholder="Your Email"
                        class="border p-3 w-full rounded-lg" value="{{ old('email') }}">
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500">
                        Password
                    </label>
                    <input type="password" id="password" name="password" placeholder="Your Password"
                        class="border p-3 w-full rounded-lg" value="{{ old('password') }}">
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="text-gray-500 text-sm">Keep session open?</label>
                </div>

                <input type="submit" value="Log in"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection
