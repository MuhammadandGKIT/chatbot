<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});



use App\Http\Controllers\ShipmentController;

Route::get('/shipments', [ShipmentController::class, 'index']);

use App\Http\Controllers\QontakController;
use App\Http\Controllers\WebhookController;

Route::post('/webhook/qontak', [QontakController::class, 'receive']);



Route::post('/webhook', [WebhookController::class, 'handle']);

