<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_user = User::firstOrCreate(
            ['email' => 'dimitry@gmail.com'], // Critères de recherche
            [
            'name' => 'dimitry',
            'password' => Hash::make('dimitry') // Valeurs pour la création
            ]
        );
        $super_user->assignRole('super admin');

        $admin = User::firstOrCreate(
            ['email' => 'dimitry+admin@gmail.com'], // Critères de recherche
            [
            'name' => 'dimitryadmin',
            'password' => Hash::make('dimitryadmin') // Valeurs pour la création
            ]
        );
        $admin->assignRole('admin');

         $user = User::firstOrCreate(
            ['email' => 'dimitry+user@gmail.com'], // Critères de recherche
            [
            'name' => 'dimitryuser',
            'password' => Hash::make('dimitryuser') // Valeurs pour la création
            ]
        );
        $user->assignRole('user');

        $moderator = User::firstOrCreate(
            ['email' => 'dimitr+modo@gmail.com'], // Critères de recherche
            [
            'name' => 'dimitrymodo',
            'password' => Hash::make('dimitrymodo') // Valeurs pour la création
            ]
        );
        $moderator->assignRole('moderator');

        $author = User::firstOrCreate(
            ['email' => 'dimitry+auteur@gmail.com'], // Critères de recherche
            [
            'name' => 'dimitryauteur',
            'password' => Hash::make('dimitryauteur') // Valeurs pour la création
            ]
        );
        $author->assignRole('author');
        
    }
}
