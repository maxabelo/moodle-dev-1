<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request->get('username')); // dumb_die <- imprime y mata/detiene la ejecucion

        // // modificar la req <- en el ultimo de los casos
        $request->request->add(['username' => Str::slug($request->username)]);


        // // Form Validations
        $this->validate($request, [
            'name' => 'required|min:1|max:33',
            'username' => 'required|unique:users|min:3|max:21',
            'email' => 'required|unique:users|max:60|email',
            'password' => 'required|confirmed|min:6',
        ]);


        // // insert user in db
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        // // Auth user
        // auth()->attempt([ // long way
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        auth()->attempt($request->only('email', 'password'));


        // redirect to another page
        return redirect()->route('posts.index');
    }
}
