<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::get('/register', 'register');
    Route::post('/register', 'doRegister');
    Route::get('/login', 'login')->middleware('onlyGuest');
    Route::post('/login', 'doLogin')->middleware('onlyGuest');
    Route::get('/update-profile', 'updateProfile')->middleware('onlyMember');
    Route::post('/update-profile', 'doUpdateProfile')->middleware('onlyMember');
    Route::post('/logout', 'doLogout')->middleware('onlyMember');
});

Route::controller(\App\Http\Controllers\TodolistController::class)
    ->middleware('onlyMember')->group(function () {
        Route::get('/todolist', 'todoList');
        Route::post('/todolist', 'addTodo');
        Route::post('/todolist/{id}/delete', 'removeTodo');
    });
