<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $name = $request->input('name');  // Obtener el nombre de usuario
        $password = $request->input('password');  // Obtener la contraseña
    
        $user = User::where('name', $name)->first();  // Buscar al usuario por nombre
    
        if ($user && $password === $user->password) {  // Comparar la contraseña directamente
            return response()->json(['success' => true, 'message' => 'Login successful']);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid credentials']);
        }
    }
    
}
