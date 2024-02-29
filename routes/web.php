<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Auth::routes();
Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');

Route::get('/', function(){
    return redirect('/home');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// items
Route::get('/listItem', [App\Http\Controllers\ItemController::class, 'index'])->name('homelist');
Route::post('/getItems', [App\Http\Controllers\ItemController::class, 'getAll'])->name('getAll');
Route::post('/addItem', [App\Http\Controllers\ItemController::class, 'addItem'])->name('addItem');
Route::post('/getItem', [App\Http\Controllers\ItemController::class, 'getItem'])->name('getItem');
Route::post('/updateItem', [App\Http\Controllers\ItemController::class, 'updateItem'])->name('updateItem');
Route::post('/deleteItem', [App\Http\Controllers\ItemController::class, 'deleteItem'])->name('deleteItem');

// ekspedisi
Route::get('/listEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'index']);
Route::post('/getEkspedisis', [App\Http\Controllers\EkspedisiController::class, 'getAll']);
Route::post('/addEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'addItem']);
Route::post('/getEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'getItem']);
Route::post('/updateEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'updateItem']);
Route::post('/deleteEkspedisi', [App\Http\Controllers\EkspedisiController::class, 'deleteItem']);

// dokter
Route::get('/listDokter', [App\Http\Controllers\DokterController::class, 'index']);
Route::post('/getDokters', [App\Http\Controllers\DokterController::class, 'getAll']);
Route::post('/addDokter', [App\Http\Controllers\DokterController::class, 'addItem']);
Route::post('/getDokter', [App\Http\Controllers\DokterController::class, 'getItem']);
Route::post('/updateDokter', [App\Http\Controllers\DokterController::class, 'updateItem']);
Route::post('/deleteDokter', [App\Http\Controllers\DokterController::class, 'deleteItem']);

// dokter
Route::get('/listCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'index']);
Route::post('/getCategoryProducts', [App\Http\Controllers\CategoryProductController::class, 'getAll']);
Route::post('/addCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'addItem']);
Route::post('/getCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'getItem']);
Route::post('/updateCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'updateItem']);
Route::post('/deleteCategoryProduct', [App\Http\Controllers\CategoryProductController::class, 'deleteItem']);

// List Product
Route::get('/listProduct', [App\Http\Controllers\ListProductController::class, 'index']);
Route::post('/addCart', [App\Http\Controllers\ListProductController::class, 'addCartDetail']);

// List Product
Route::get('/viewCart', [App\Http\Controllers\CartController::class, 'index']);
Route::post('/addPO', [App\Http\Controllers\CartController::class, 'addPO']);

Route::get('/listPO', [App\Http\Controllers\ListPOController::class, 'index']);
Route::post('/getCart', [App\Http\Controllers\ListPOController::class, 'getListAllCart']);
Route::get('/detailPO/{id}', [App\Http\Controllers\ListPOController::class, 'detailPOIndex']);
Route::post('/canceledPO', [App\Http\Controllers\ListPOController::class, 'canceledOrder']);
Route::post('/packingPO', [App\Http\Controllers\ListPOController::class, 'packingOrder']);
Route::post('/sentPO', [App\Http\Controllers\ListPOController::class, 'sentOrder']);
Route::post('/updateStatus', [App\Http\Controllers\ListPOController::class, 'updateStatus']);
Route::post('/paymentOrder', [App\Http\Controllers\ListPOController::class, 'paymentOrder']);

// productBundle
Route::get('/listProductBundle', [App\Http\Controllers\PackageController::class, 'index']);
Route::post('/getProductBundles', [App\Http\Controllers\PackageController::class, 'getAll']);
Route::post('/addProductBundle', [App\Http\Controllers\PackageController::class, 'addItem']);
Route::post('/getProductBundle', [App\Http\Controllers\PackageController::class, 'getItem']);
Route::post('/updateProductBundle', [App\Http\Controllers\PackageController::class, 'updateItem']);
Route::post('/deleteProductBundle', [App\Http\Controllers\PackageController::class, 'deleteItem']);
