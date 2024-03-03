<?php

use Illuminate\Support\Facades\Route;


Auth::routes();


Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');


Route::get('/', function(){
    return redirect('/home');
});

Route::get('password/reset', function () {
    return redirect('/listItem');
});


Route::post('/getNotif', [App\Http\Controllers\NotifController::class, 'getAll'])->name('getAll');


Route::get('/listUser', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// items
Route::get('/listItem', [App\Http\Controllers\ItemController::class, 'index'])->name('homelist')->middleware('auth');
Route::post('/getItems', [App\Http\Controllers\ItemController::class, 'getAll'])->name('getAll')->middleware('auth');
Route::post('/addItem', [App\Http\Controllers\ItemController::class, 'addItem'])->name('addItem')->middleware('auth');
Route::post('/getItem', [App\Http\Controllers\ItemController::class, 'getItem'])->name('getItem')->middleware('auth');
Route::post('/updateItem', [App\Http\Controllers\ItemController::class, 'updateItem'])->name('updateItem')->middleware('auth');
Route::post('/deleteItem', [App\Http\Controllers\ItemController::class, 'deleteItem'])->name('deleteItem')->middleware('auth');

// ekspedisi
Route::get('/listEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'index'])->middleware('auth');
Route::post('/getEkspedisis', [App\Http\Controllers\EkspedisiController::class, 'getAll'])->middleware('auth');
Route::post('/addEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'addItem'])->middleware('auth');
Route::post('/getEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'getItem'])->middleware('auth');
Route::post('/updateEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'updateItem'])->middleware('auth');
Route::post('/deleteEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'deleteItem'])->middleware('auth');

// dokter
Route::get('/listDokter', [App\Http\Controllers\DokterController::class, 'index'])->middleware('auth');
Route::post('/getDokters', [App\Http\Controllers\DokterController::class, 'getAll'])->middleware('auth');
Route::post('/addDokter', [App\Http\Controllers\DokterController::class, 'addItem'])->middleware('auth');
Route::post('/getDokter', [App\Http\Controllers\DokterController::class, 'getItem'])->middleware('auth');
Route::post('/updateDokter', [App\Http\Controllers\DokterController::class, 'updateItem'])->middleware('auth');
Route::post('/deleteDokter', [App\Http\Controllers\DokterController::class, 'deleteItem'])->middleware('auth');

// dokter
Route::get('/listCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'index'])->middleware('auth');
Route::post('/getCategoryProducts', [App\Http\Controllers\CategoryProductController::class, 'getAll'])->middleware('auth');
Route::post('/addCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'addItem'])->middleware('auth');
Route::post('/getCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'getItem'])->middleware('auth');
Route::post('/updateCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'updateItem'])->middleware('auth');
Route::post('/deleteCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'deleteItem'])->middleware('auth');

// List Product
Route::get('/listProduct', [App\Http\Controllers\ListProductController::class, 'index'])->middleware('auth');
Route::post('/addCart', [App\Http\Controllers\ListProductController::class, 'addCartDetail'])->middleware('auth');

// List Product
Route::get('/viewCart', [App\Http\Controllers\CartController::class, 'index']);
Route::post('/addPO', [App\Http\Controllers\CartController::class, 'addPO']);

Route::get('/listPO', [App\Http\Controllers\ListPOController::class, 'index']);
Route::post('/getCart', [App\Http\Controllers\ListPOController::class, 'GetListCart']);
// productBundle
Route::get('/listProductBundle', [App\Http\Controllers\PackageController::class, 'index']);
Route::post('/getProductBundles', [App\Http\Controllers\PackageController::class, 'getAll']);
Route::post('/addProductBundle', [App\Http\Controllers\PackageController::class, 'addItem']);
Route::post('/getProductBundle', [App\Http\Controllers\PackageController::class, 'getItem']);
Route::post('/updateProductBundle', [App\Http\Controllers\PackageController::class, 'updateItem']);
Route::post('/deleteProductBundle', [App\Http\Controllers\PackageController::class, 'deleteItem']);
