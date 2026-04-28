<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController
{
    public function index(): JsonResponse
    {
        $users = array_map(fn(User $u) => $u->toArray(), User::all());
        return response()->json($users);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user->toArray());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        if (empty($data['name']) || empty($data['email']) || !isset($data['age'])) {
            return response()->json(['error' => 'name, email y age son requeridos'], 400);
        }

        $user = User::create($data['name'], $data['email'], (int) $data['age']);
        return response()->json($user->toArray(), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->json()->all();
        $user = User::update($id, $data);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user->toArray());
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = User::delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['message' => 'Usuario eliminado']);
    }
}
