<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Admin and Super Admin
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Admin and Super Admin
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }


    /**
     * Admin and Super Admin
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    /**
     * Admin and Super Admin
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * Super Admin
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        $user->delete();
        return response()->json(null, 204);

    }

    /**
     * All roles
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * All roles
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function updateProfile(Request $request)
     {
         // Valider et mettre à jour l'utilisateur
         $user = $request->user();
         $data = $request->validate([
             'name' => 'required|string|max:255',
             // autres champs que vous souhaitez mettre à jour...
         ]);
         
         $user->update($data);
 
         return response()->json(['message' => 'Profil mis à jour', 'user' => $user], 200);
     }

      /**
     * Admin
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
         public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'Vous ne pouvez pas supprimer votre propre compte.'], 403);
        } else if ($user->hasRole('super admin')) {
            return response()->json(['message' => 'Vous ne pouvez pas supprimer un super administrateur.'], 403);
        }
        else {
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé.'], 200);
        }
    }

     
    /**
     * User and Super Admin
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
         public function deleteProfile(Request $request)
    {
        $user = $request->user();

        $user->delete();

        return response()->json(['message' => 'Votre compte a été supprimé.'], 200);
    }

     /**
     * Admin
     * Assign a role to a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
        public function adminAssignRole(Request $request, $user_id)
   {
    //admin cant assign a role to a admin or super admin 
    $user = User::findOrFail($user_id);
    if ($user->hasRole('admin') || $user->hasRole('super admin')) {
        return response()->json(['message' => 'Vous ne pouvez pas assigner un rôle à un administrateur ou un super administrateur.'], 403);
    } else {
        // Validation des données
        $data = $request->validate([
            'role' => 'required|exists:roles,name', // Vérifie si le rôle existe dans la table `roles`
        ]);

        try {
            // Trouve le rôle avec le `guard_name` correct
            $role = Role::findByName($data['role'], 'web');

            // Synchronise les rôles
            $user->syncRoles([$role]);

            return response()->json([
                'message' => "Le rôle {$role->name} a été assigné à l'utilisateur {$user->name}.",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de l\'assignation du rôle.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}

     /**
     * Super Admin
     * Assign a role to a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
      public function superAssignRole(Request $request, $user_id)
{
    $user = User::findOrFail($user_id);

    // Validation des données
    $data = $request->validate([
        'role' => 'required|exists:roles,name', // Vérifie si le rôle existe dans la table `roles`
    ]);

    try {
        // Trouve le rôle avec le `guard_name` correct
        $role = Role::findByName($data['role'], 'web');

        // Synchronise les rôles
        $user->syncRoles([$role]);

        return response()->json([
            'message' => "Le rôle {$role->name} a été assigné à l'utilisateur {$user->name}.",
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Une erreur est survenue lors de l\'assignation du rôle.',
            'details' => $e->getMessage(),
        ], 500);
    }
}
    /**
     * Super Admin
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function superUpdate(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        // Valider et mettre à jour l'utilisateur
        $data = $request->validate([
            'name' => 'required|string|max:255',
            // autres champs que vous souhaitez mettre à jour...
        ]);

        $user->update($data);

        return response()->json(['message' => 'Profil mis à jour', 'user' => $user], 200);
    }
    

}
