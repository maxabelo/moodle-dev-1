<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{

    // protect routes
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.index');
    }

    public function store(Request $request)
    {
        // modify request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => [
                'required',
                'unique:users,username,' . auth()->user()->id,  // no validar el username propio
                'min:2',
                'max:21',
                'not_in:twitter,edit-profile'
            ]
        ]);


        // img
        if ($request->image) {
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->extension();

            $imageToStore = Image::make($image);
            $imageToStore->fit(1000, 1000, null, 'center'); // dimensions

            // store in public/profiles
            $imagePath = public_path('profiles') . '/' . $imageName;
            $imageToStore->save($imagePath);
        }

        // save changes - use auth() because of user can change username
        $user = User::find(auth()->user()->id);

        $user->username = $request->username;
        $user->image = $imageName ?? auth()->user()->image ?? null;
        $user->save();


        // redirect
        return redirect()->route('posts.index', $user->username);
    }
}
