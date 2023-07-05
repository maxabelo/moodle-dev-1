<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',  // lo agregamos manualmente tras run la migration q agrega esta colum
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // // Relations
    public function posts()
    {
        // x usar la convencion, Laravel sabe la FK y no hace falta especificarle
        return $this->hasMany(Post::class); // OneToMany
    }

    // likes
    public function likes()
    {
        return $this->hasMany(Like::class); // OneToMany
    }

    // persist followers
    public function followers()
    {
        // Model, table, FK, FK  <--  2 FK 'cause this is a pivot table
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');  // ManyToMany - pivot table
    }

    // persist follogins: solo se invierte el orden de las columnas xq mientras mi id este al lado izquiero significa q me estan siguiendo, pero cuando mi id esta a la derecha en follower_id, significa q yo soy el follower y estoy siguiendo a otras personas
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');  // ManyToMany - pivot table
    }

    // // another methods

    // check if a user is already following another user
    public function isFollowingByUser(User $user)
    {
        return $this->followers->contains($user->id);
    }
}
