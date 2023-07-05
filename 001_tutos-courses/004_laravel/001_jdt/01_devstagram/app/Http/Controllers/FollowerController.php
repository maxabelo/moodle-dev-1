<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(Request $request, User $user)
    {
        // // lo q viene en este controller en especifico
        // $user q me pasa la view = profile q voy a seguir
        // $request->user() = user q hace la request
        // $auth()->user() = authenticared user
        // dd(['user' => $user, 'user_request' => $request->user(), 'auth' => auth()->user()]);


        // // ManyToMany: attach 'cause we don't follow conventions for this table. Both of them belongs to the same table/model
        $user->followers()->attach(auth()->user()->id);

        return back();
    }

    public function destroy(User $user)
    {
        $user->followers()->detach(auth()->user()->id);

        return back();
    }
}
