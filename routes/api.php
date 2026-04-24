<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes  —  equivalente a routes/users.ts
|--------------------------------------------------------------------------
|
| Node/Express original:
|   router.get('/users',       getAllUsers)
|   router.get('/users/:id',   getUserById)
|   router.post('/users',      createUser)
|   router.put('/users/:id',   updateUser)
|   router.delete('/users/:id',deleteUser)
|
| Todas quedan bajo el prefijo /api  (configurado en bootstrap/app.php)
|
*/

// Ruta de bienvenida — equivalente a app.get('/', ...)
Route::get('/', function () {
    return response()->json([
        'message' => 'Message:Bienvenido a la API',
        'version' => '1.0.0',
    ]);
});

// CRUD de usuarios
Route::get('/users',        [UserController::class, 'index']);    // GET    /api/users
Route::get('/users/{id}',   [UserController::class, 'show']);     // GET    /api/users/{id}
Route::post('/users',       [UserController::class, 'store']);    // POST   /api/users
Route::put('/users/{id}',   [UserController::class, 'update']);   // PUT    /api/users/{id}
Route::delete('/users/{id}',[UserController::class, 'destroy']);  // DELETE /api/users/{id}

// Manejo de rutas no encontradas — equivalente al middleware 404 de Express
Route::fallback(function () {
    return response()->json(['error' => 'Ruta no encontrada'], 404);
});