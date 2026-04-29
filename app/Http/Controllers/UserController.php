<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController
{
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        if (empty($data['name']) || empty($data['email']) || !isset($data['age'])) {
            return response()->json(['error' => 'name, email y age son requeridos'], 400);
        }

        if (User::where('email', $data['email'])->exists()) {
            return response()->json(['error' => 'El email ya está registrado'], 409);
        }

        $user = User::create([
            'name'  => $data['name'],
            'email' => $data['email'],
            'age'   => (int) $data['age'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado exitosamente',
            'data'    => $user,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $data = array_filter($request->json()->all(), fn($v) => $v !== null);
        $user->update($data);

        return response()->json($user);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado']);
    }
}
