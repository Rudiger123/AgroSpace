<?php

// routes/web.php

use App\Livewire\Demands\MyDemands;
use App\Livewire\Demands\PublicDemands;
use App\Livewire\Admin\ManageDemands;

// Routes protégées (authentification requise)
Route::middleware(['auth'])->group(function () {
    
    // Routes Consommateur - Mes Demandes
    Route::get('/mes-demandes', MyDemands::class)
        ->name('demands.my');
    
    // Routes Publiques - Explorer les demandes (accessible à tous)
    Route::get('/demandes', PublicDemands::class)
        ->name('demands.public');
});

// Routes Admin (authentification + rôle admin requis)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/demandes', ManageDemands::class)
        ->name('demands.index');
});

// ============================================
// routes/api.php
// ============================================

use App\Http\Controllers\Api\DemandController;

Route::prefix('v1')->group(function () {
    
    // Routes publiques
    Route::get('demands', [DemandController::class, 'index']);
    Route::get('demands/{id}', [DemandController::class, 'show']);
    
    // Routes protégées
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('demands', [DemandController::class, 'store']);
        Route::put('demands/{id}', [DemandController::class, 'update']);
        Route::delete('demands/{id}', [DemandController::class, 'destroy']);
        Route::post('demands/{id}/respond', [DemandController::class, 'respond']);
    });
});