<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FuelLogController;

Route::middleware('api')->group(function () {

    // LOGIN (Público)
    Route::post('/login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    });

    // 🔐 RUTAS PROTEGIDAS POR SANCTUM
    Route::middleware('auth:sanctum')->group(function () {

        // VEHICLES
        Route::get('/vehicles', [VehicleController::class, 'index']);
        Route::post('/vehicles', [VehicleController::class, 'store']);
        Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

        // DOCUMENTS
        Route::get('/vehicles/{id}/documents', [DocumentController::class, 'index']);
        Route::post('/vehicles/{id}/documents', [DocumentController::class, 'store']);

        // FUEL LOGS
        Route::get('/vehicles/{id}/fuel_logs', [FuelLogController::class, 'index']);
        Route::post('/vehicles/{id}/fuel_logs', [FuelLogController::class, 'store']);

        // LOGOUT (opcional)
        Route::post('/logout', function (Request $request) {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Sesión cerrada']);
        });
    });
});
