<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * UserController
 * 
 * Equivalente directo de userController.ts:
 *   getAllUsers  → GET  /api/users
 *   getUserById → GET  /api/users/{id}
 *   createUser  → POST /api/users
 *   updateUser  → PUT  /api/users/{id}
 *   deleteUser  → DELETE /api/users/{id}
 */
class UserController extends Controller
{
    // -------------------------------------------------------
    // GET /api/users
    // Equivalente a: export const getAllUsers
    // -------------------------------------------------------

    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
    'success' => true,
    'data'    => $users->toArray(),
    'total'   => $users->count(),
]);
    }

    // -------------------------------------------------------
    // GET /api/users/{id}
    // Equivalente a: export const getUserById
    // -------------------------------------------------------

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
            'data'    => $user->toArray(),
        ]);
    }

    // -------------------------------------------------------
    // POST /api/users
    // Equivalente a: export const createUser
    // -------------------------------------------------------

    public function store(Request $request): JsonResponse
    {
        $name  = $request->input('name');
        $email = $request->input('email');
        $age   = $request->input('age');

        // Validar los datos de entrada
        if (!$name || !$email || !$age) {
            return response()->json([
                'success' => false,
                'error'   => 'Todos los campos son obligatorios',
            ], 400);
        }

       $newUser = User::create([
    'name'  => $name,
    'email' => $email,
    'age'   => (int) $age,
]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado exitosamente',
            'data'    => $newUser->toArray(),
        ], 201);
    }

    // -------------------------------------------------------
    // PUT /api/users/{id}
    // Equivalente a: export const updateUser
    // -------------------------------------------------------

    public function update(Request $request, int $id): JsonResponse
    {
        $data = array_filter([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'age'   => $request->input('age'),
        ]);

        $user = User::find($id);

if (!$user) {
    return response()->json([
        'success' => false,
        'error'   => "Usuario con ID {$id} no encontrado",
    ], 404);
}

$user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado exitosamente',
            'data'    => $user->toArray(),
        ]);
    }

    // -------------------------------------------------------
    // DELETE /api/users/{id}
    // Equivalente a: export const deleteUser
    // -------------------------------------------------------

    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);
$deleted = $user ? $user->delete() : false;

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => "Usuario con id {$id} no encontrado",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente',
        ]);
    }
}
