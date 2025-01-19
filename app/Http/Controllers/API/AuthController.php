<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register(Request $request)
    
        {
            try {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                ]);
        
                $user = User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                ]);
        
                return response()->json($user, 201);
        
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['error' => 'Validation error', 'messages' => $e->errors()], 422);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
            }
        }    

    public function login(Request $request)
    {
        try {
        // Valider les entrées
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenter de se connecter avec les informations d'identification fournies
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        // Retourner une réponse d'erreur si les informations d'identification sont invalides
        return response()->json(['message' => 'Invalid credentials'], 401);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Gérer les erreurs de validation
        return response()->json(['error' => 'Validation error', 'messages' => $e->errors()], 422);
    } catch (\Exception $e) {
        // Gérer les autres erreurs
        return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
    }
}

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    
    
}
