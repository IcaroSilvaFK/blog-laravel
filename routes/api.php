<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentsController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/posts/home", [Home::class, 'index']);
Route::post("/posts/store", [Home::class, 'store']);
Route::get("/posts/{id}", [Home::class, 'showById']);
Route::delete("/posts/{id}", [Home::class, "destroy"]);
Route::post("/users/store",[UserController::class,"index"]);
Route::post("/users/login",[UserController::class,"login"])->middleware("guest:sanctum");
Route::get("/users/me",[UserController::class,"me"])->middleware("auth:sanctum");
Route::post("/users/{id}",[UserController::class,"showPublications"]);
Route::delete("/users/{id}",[UserController::class,"destroy"]);
ROute::post("/comments/store",[CommentsController::class,"index"]);
