<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post("/store", [App\Http\Controllers\HomeController::class, 'store'])->name("task.store");
Route::put("/{task}/update", [App\Http\Controllers\HomeController::class, 'update'])->name("task.update");
Route::delete("/{task}/destroy", [App\Http\Controllers\HomeController::class, 'destroy'])->name("task.destroy");

\Illuminate\Support\Facades\Auth::routes();
