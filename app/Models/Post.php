<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Variables autorisées pour le remplissage
    protected $fillable = [
        'title',
        'content',
        'autheur',
        'status'
    ];
    
    // Relation : Un post a plusieurs commentaires
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relation : Un post appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }


    



}
