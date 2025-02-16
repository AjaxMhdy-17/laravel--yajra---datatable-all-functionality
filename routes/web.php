<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('', [UserController::class , 'index'])->name('user.index');

Route::controller(UserController::class)->group(function(){
    Route::get('', 'index')->name('user.index');
    Route::get('user/{id}/edit', 'edit')->name('user.edit');
    Route::delete('user/{id}/delete', 'destroy')->name('user.delete');
});

