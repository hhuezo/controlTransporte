<?php

use App\Http\Controllers\ControlViajeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\seguridad\PermissionController;
use App\Http\Controllers\seguridad\RoleController;
use App\Http\Controllers\seguridad\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//seguridad
Route::resource('seguridad/permission', PermissionController::class);
Route::post('seguridad/role/update_permission', [RoleController::class, 'updatePermission']);
Route::resource('seguridad/role', RoleController::class);
Route::post('seguridad/user/update_password/{id}', [UserController::class, 'updatePassword']);
Route::resource('seguridad/user', UserController::class);


Route::resource('control', ControlViajeController::class);
