<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // x relaciones en laravel - no necesito especificar el post_id xq parto de esa instancia <- Relacion ManyToMany, como seguimos las convenciones NO necesitamos attach() xq aqui son MODELOS/TABLAS Distintas
        $post->likes()->create([
            'user_id' => $request->user()->id,  // auth() user de la request
        ]);

        return back();  // solo es like, retorna de nuevo a la misma url
    }

    public function destroy(Request $request, Post $post)
    {
        // Gracias a las relaciones de laravel ya tiene el user_id del user x el likes() en el User model, solo falta el post_id
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
