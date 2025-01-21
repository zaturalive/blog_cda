<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Création de permissions
        $permissions = [
            'edit post', 'delete post', 'publish post', 'create post',
            'edit users', 'delete users', 'create users', 'view users',
            'edit own profile', 'view own profile', 'delete own profile',
            'manage users', 'assign roles', 'change post state',
            'delete comment', 'create comment'
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        $userRole = Role::findOrCreate('user');
        $adminRole = Role::findOrCreate('admin');
        $superAdminRole = Role::findOrCreate('super admin');
        
        // Utilisateur de base
        $userRole->givePermissionTo([
            'view own profile', 
            'edit own profile', 
            'delete own profile',
            'create comment',  // Peut créer des commentaires
            'delete comment'   // Peut supprimer ses propres commentaires
        ]);
        
        // Administrateur
        $adminRole->givePermissionTo([ 
            'view own profile',
            'edit own profile',
            'delete users',
            'edit users',
            'view users',
            'create users',
            'manage users',
            'edit post',
            'delete post',
            'publish post',
            'create comment',
            'delete comment',
            'change post state'
        ]);
        
        // Super Admin
        $superAdminRole->givePermissionTo([
            'assign roles',
            'view own profile',
            'edit own profile',
            'delete users',
            'edit users',
            'view users',
            'create users',
            'delete own profile',
            'edit post',
            'delete post',
            'publish post',
            'create post',
            'create comment',
            'delete comment',
            'change post state',
            'manage users'
        ]);
        
        // Auteur
        $authorRole = Role::findOrCreate('author');
        $authorRole->givePermissionTo([
            'view own profile',
            'edit own profile',
            'delete own profile',
            'create post',     // Peut créer des posts
            'edit post',       // Peut éditer ses propres posts
            'publish post',    // Peut publier ses posts
            'create comment',  // Peut commenter
            'delete comment'   // Peut supprimer ses commentaires
        ]);
        
        // Modérateur
        $moderatorRole = Role::findOrCreate('moderator');
        $moderatorRole->givePermissionTo([
            'view own profile',
            'edit own profile',
            'delete own profile',
            'edit post',       // Peut éditer tous les posts
            'delete post',     // Peut supprimer tous les posts
            'publish post',    // Peut publier/dépublier les posts
            'change post state',
            'create comment',
            'delete comment'   // Peut supprimer tous les commentaires
        ]);

        // Ici, vous pourriez logiquement restreindre l'utilisateur à n'agir que sur son propre profil via la logique de l'application,
        // en utilisant par exemple un middleware ou des vérifications dans les contrôleurs.
    }
       

}