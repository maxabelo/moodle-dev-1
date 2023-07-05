<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

// Como el de Components q maneja la logica y la data
class LikePost extends Component
{
    // definir aqui las variables q se vayan a pasar a la view
    public Post $post;
    public bool $isLiked;
    public int $likes;

    // // ciclo de vida de livewire - mount() al montarse el component, como el constructor
    public function mount($post)
    {
        // $post lo pasa la view
        $this->isLiked = $post->checkLike(auth()->user());

        $this->likes = $post->likes->count();
    }


    public function like()
    {
        if ($this->post->checkLike(auth()->user())) {
            // Gracias a las relaciones de laravel ya tiene el user_id del user x el likes() en el User model, solo falta el post_id
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked = false; // re-render de la view
            $this->likes--;  // reactivo
        } else {
            // x relaciones en laravel - no necesito especificar el post_id xq parto de esa instancia <- Relacion ManyToMany, como seguimos las convenciones NO necesitamos attach() xq aqui son MODELOS/TABLAS Distintas
            $this->post->likes()->create([
                'user_id' => auth()->user()->id,
            ]);
            $this->isLiked = true; // re-render
            $this->likes++;  // reactivo
        }
    }

    public function render()
    {

        return view('livewire.like-post');
    }
}
