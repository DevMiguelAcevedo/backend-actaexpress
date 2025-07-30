<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    // Crear un nuevo usuario (registro directo desde API)
    public function store(Request $request)
    {
        $data = $request->validate([
            'identificacion' => 'required|string|unique:users',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users',
            'phone'          => 'nullable|string',
            'password'       => 'required|string|min:6|confirmed',
            'roles'          => 'required|array',
        ]);

        $user = User::create([
            'identificacion' => $data['identificacion'],
            'name'           => $data['name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'] ?? null,
            'password'       => $data['password'],
            'roles'          => $data['roles'],
        ]);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user'    => $user,
        ], 201);
    }

    // Mostrar un usuario por ID
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json($user, 200);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $data = $request->validate([
            'identificacion' => 'sometimes|string|unique:users,identificacion,' . $id,
            'name'           => 'sometimes|string|max:255',
            'email'          => 'sometimes|email|unique:users,email,' . $id,
            'phone'          => 'nullable|string',
            'password'       => 'nullable|string|min:6|confirmed',
            'roles'          => 'sometimes|array',
        ]);

        // Solo actualiza la contraseña si se envía
        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        $user->fill($data)->save();

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'user'    => $user,
        ]);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
