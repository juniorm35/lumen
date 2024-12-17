<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function register(Request $request)
    {
        // Validar que los campos necesarios estén presentes
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verificar si el email ya está registrado
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            return response()->json([
                'success' => false,
                'message' => 'Email is already taken'
            ], 400);  // Error 400 - Solicitud incorrecta (el correo ya existe)
        }

        // Crear el usuario
        $newUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),  // Aquí no estamos cifrando la contraseña
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
        ], 201);  // Respuesta 201 - Creado
    }

    

    public function create(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->save();

            return response()->json(['message' => 'User created successfully']);
        } catch (\Exception $e) {
            Log::error('Error in create method: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the user', 'details' => $e->getMessage()], 500);
        }
    }

    // Get all users
    public function index()
    {
        try {
            return response('Hello World!', 200);
        } catch (\Exception $e) {
            Log::error('Error in index method: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred', 'details' => $e->getMessage()], 500);
        }
    }

    // Get a single user
    public function show($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            Log::error('Error in show method: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching the user', 'details' => $e->getMessage()], 500);
        }
    }

    // Update a user
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error in update method: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the user', 'details' => $e->getMessage()], 500);
        }
    }

    // Delete a user
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            $user->delete();

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error in destroy method: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the user', 'details' => $e->getMessage()], 500);
        }
    }
}
