<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function init()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // remember para generar token en db y cookie y mantener la session
        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            // whith coloca el message en la SESSION y lo podemos recuperar en la view
            return back()->with('message', 'Incorrect Credentials'); // back a la prev page
        }


        // x el route model binding necesita el username para la url
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
