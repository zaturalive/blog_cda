<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

        // Variables autorisées pour le remplissage
        protected $fillable = ['author', 'message', 'status', 'post_id'];

        // Relation : Un commentaire appartient à un post
        public function post()
        {
            return $this->belongsTo(Post::class);
        }
    
        // Relation : Un commentaire appartient à un utilisateur
        public function user()
        {
            return $this->belongsTo(User::class, 'author');
        }
}
