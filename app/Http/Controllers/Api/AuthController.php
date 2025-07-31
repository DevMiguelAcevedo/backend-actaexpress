<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'identificacion' => 'required|string|unique:users',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'password' => 'required|string|min:6',
            'roles' => 'required|array'
        ]);

        $user = User::create([
            'identificacion' => $validated['identificacion'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'roles' => $validated['roles']
        ]);

        // Enviar correo de bienvenida
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user, $validated['password']));
            Log::info("Correo enviado a {$user->email}");

            return response()->json([
                'message' => 'Usuario registrado y correo enviado',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error("Fallo envío de correo: " . $e->getMessage());

            return response()->json([
                'message' => 'Usuario registrado pero falló el correo',
                'user' => $user,
                'error' => $e->getMessage()
            ], 201);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        return response()->json([
            'message' => 'Login exitoso',
            'user'    => Auth::guard('api')->user(),
            'token'   => $token,
        ], 200)->header('Access-Control-Expose-Headers', 'Authorization');
    }


    public function profile()
    {
        return response()->json(auth('api')->user());
    }


    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
