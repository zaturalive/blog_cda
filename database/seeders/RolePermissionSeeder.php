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
            'edit articles', 'delete articles', 'publish articles', 
            'edit users', 'delete users', 'create users', 'view users',
            'edit own profile', // Permission spécifique pour les actions sur le profil utilisateur
            'view own profile',  // Permission pour voir son propre profil
            'delete own profile', // Permission pour supprimer son propre profil
            'manage users', 'assign roles'
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
       
    $userRole = Role::findOrCreate('user');
    $adminRole = Role::findOrCreate('admin');
    $superAdminRole = Role::findOrCreate('super admin');

    $userRole->givePermissionTo([
        'view own profile', 
        'edit own profile', 
        'delete own profile'
    ]);

    $adminRole->givePermissionTo([ 
    'view own profile',
    'edit own profile',
    'delete users',
    'edit users',
    'view users',
    'create users',
    'manage users',
        'edit articles',
        'delete articles',
        'publish articles'
    ]);

    $superAdminRole->givePermissionTo([
    'assign roles',
    'view own profile',
    'edit own profile',
    'delete users',
    'edit users',
    'view users',
    'create users',
    'delete own profile',
        'edit articles',
        'delete articles',
        'publish articles'
]);
    //Auteur Role (a les memes droit qu'un user) + droit d'écriture d'articles
    $authorRole = Role::findOrCreate('author');
    $authorRole->givePermissionTo([
        'view own profile',
        'edit own profile',
        'delete own profile',
        'edit articles',
        'publish articles'
    ]);
    
    // Role Modérateur (a les memes droits qu'un autheur) + droit de suppression d'articles
    $moderatorRole = Role::findOrCreate('moderator');
    $moderatorRole->givePermissionTo([
        'view own profile',
        'edit own profile',
        'delete own profile',
        'edit articles',
        'delete articles',
        'publish articles'
    ]);

        // Ici, vous pourriez logiquement restreindre l'utilisateur à n'agir que sur son propre profil via la logique de l'application,
        // en utilisant par exemple un middleware ou des vérifications dans les contrôleurs.
    }
       

}