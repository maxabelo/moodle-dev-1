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
}
