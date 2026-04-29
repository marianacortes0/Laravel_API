<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /api/users
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'data'    => $users,
            'total'   => $users->count(),
        ]);
    }

    // GET /api/users/{id}
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error'   => "Usuario con ID {$id} no encontrado",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $user,
        ]);
    }

    // POST /api/users
    public function store(Request $request): JsonResponse
    {
        $name  = $request->input('name');
        $email = $request->input('email');
        $age   = $request->input('age');

        if (!$name || !$email || !$age) {
            return response()->json([
                'success' => false,
                'error'   => 'Todos los campos son obligatorios',
            ], 400);
        }

        $user = User::create([
            'name'  => $name,
            'email' => $email,
            'age'   => (int) $age,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado exitosamente',
            'data'    => $user,
        ], 201);
    }

    // PUT /api/users/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'error'   => "Usuario con ID {$id} no encontrado",
            ], 404);
        }

        $data = array_filter([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'age'   => $request->input('age'),
        ]);

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado exitosamente',
            'data'    => $user,
        ]);
    }

    // DELETE /api/users/{id}
    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "Usuario con id {$id} no encontrado",
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente',
        ]);
    }
}
