<?php

use Illuminate\Support\Facades\Route;


Auth::routes();
Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');

Route::get('/', function(){
    return redirect('/home');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

//items
Route::get('/listItem', [App\Http\Controllers\ItemController::class, 'index'])->name('homelist');
Route::post('/getItems', [App\Http\Controllers\ItemController::class, 'getAll'])->name('getAll');
Route::post('/addItem', [App\Http\Controllers\ItemController::class, 'addItem'])->name('addItem');
Route::post('/getItem', [App\Http\Controllers\ItemController::class, 'getItem'])->name('getItem');
Route::post('/updateItem', [App\Http\Controllers\ItemController::class, 'updateItem'])->name('updateItem');
Route::post('/deleteItem', [App\Http\Controllers\ItemController::class, 'deleteItem'])->name('deleteItem');

