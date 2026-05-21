<?php

// Author: Emily Cardona Castañeda

use App\Http\Controllers\Api\PlantApiController;
use Illuminate\Support\Facades\Route;

Route::get('/plants', [PlantApiController::class, 'index'])->name('api.plant.index');
Route::get('/plants/{id}', [PlantApiController::class, 'show'])->name('api.plant.show');
