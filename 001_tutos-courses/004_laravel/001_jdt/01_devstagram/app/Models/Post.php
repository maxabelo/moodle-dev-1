<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable. Attributes that will be stored in DB.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',  // lo agregamos manualmente tras run la migration q agrega esta colum
    ];


    public function user()
    {
        return $this->belongsTo(User::class)->select([
            'name',
            'username'
        ]); // ManyToOne
    }

    // gracias a estas Asociaciones, Laravel nos implementa todo para acceder a los comments de este post. Sin tener que hacer where, Join, etc de sql. Todo esto laravel ya lo hace behind the scenes 
    public function comments()
    {
        return $this->hasMany(Comment::class); // OneToMany
    }

    // likes al post - x estas relaciones ya laravel los asocia directemente x medio de post
    // $post->likes()->create([]);
    public function likes()
    {
        return $this->hasMany(Like::class); // OneToMany
    }

    // revisar si ya le ha dado like
    public function checkLike(User $user)
    {
        // se pocisiona en la tabla de likes, y check si la tabla contiene en la columna user_id ese value
            // debido a la relacion y al modelo asociado a la migracion y al controller, se situa de inmediato en la tabla de likes y el contains verifica en cualquiera de la tabla 
        return $this->likes->contains('user_id', $user->id);
    }
}
