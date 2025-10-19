<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
// Servir imágenes de mascotas
Route::get('/pet-photos/{filename}', function ($filename) {
    $path = storage_path('app/petPhotos/' . $filename);
    
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header('Content-Type', $type);
})->name('pet.photos');

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('pets', PetController::class);
    Route::apiResource('owners', \App\Http\Controllers\OwnerController::class);
});