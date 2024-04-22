<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\clientController;

Route::get("/clients", [clientController::class, "getClients"]);

Route::get("/clients/{id}", [clientController::class, "getClient"]);

Route::post("/clients", [clientController::class, "postClient"]);

Route::put("/clients/{id}", [clientController::class, "putClient"]);

Route::patch("/clients/{id}", [clientController::class, "updatePartialClient"]);

Route::delete("/clients/{id}", [clientController::class, "deleteController"]);