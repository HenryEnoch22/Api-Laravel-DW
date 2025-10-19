<?php

use App\Http\Controllers\PetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

//    Route::post('/pets', [PetController::class, 'store']);
    // CRUD de mascotas
    Route::apiResource('pets', PetController::class);

});

//require __DIR__.'/auth.php';
