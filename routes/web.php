<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
Route::post('/updateCart', [App\Http\Controllers\ListProductController::class, 'update'])->middleware('auth');

// List Product
Route::get('/viewCart', [App\Http\Controllers\CartController::class, 'index'])->name('viewCart')->middleware('auth');
Route::post('/addPO', [App\Http\Controllers\CartController::class, 'addPO'])->middleware('auth');

Route::get('/listPO', [App\Http\Controllers\ListPOController::class, 'index'])->middleware('auth');
Route::post('/getAllPO', [App\Http\Controllers\ListPOController::class, 'getAll'])->middleware('auth');
Route::post('/getAllTransaction', [App\Http\Controllers\ListPOController::class, 'getAllTransaction'])->middleware('auth');
Route::post('/getCart', [App\Http\Controllers\ListPOController::class, 'getListAllCart'])->middleware('auth');
Route::get('/detailPO/{id}', [App\Http\Controllers\ListPOController::class, 'detailPOIndex'])->middleware('auth');
Route::get('/detailTransaction/{id}', [App\Http\Controllers\ListPOController::class, 'detailTransaksiIndex'])->middleware('auth');
Route::post('/canceledPO', [App\Http\Controllers\ListPOController::class, 'canceledOrder'])->middleware('auth');
Route::post('/packingPO', [App\Http\Controllers\ListPOController::class, 'packingOrder'])->middleware('auth');
Route::post('/sentPO', [App\Http\Controllers\ListPOController::class, 'sentOrder'])->middleware('auth');
Route::post('/updateStatus', [App\Http\Controllers\ListPOController::class, 'updateStatus'])->middleware('auth');
Route::post('/paymentOrder', [App\Http\Controllers\ListPOController::class, 'paymentOrder'])->middleware('auth');
Route::post('/stepPaymentOrder', [App\Http\Controllers\ListPOController::class, 'stepPaymentOrder'])->middleware('auth');
Route::post('/editStepPaymentOrder', [App\Http\Controllers\ListPOController::class, 'editStepPaymentOrder'])->middleware('auth');
Route::post('/addExtraCharge', [App\Http\Controllers\ListPOController::class, 'addExtraCharge'])->middleware('auth');
Route::post('/editProduct', [App\Http\Controllers\ListPOController::class, 'editProduct'])->middleware('auth');
Route::get('/generate-pdf', [App\Http\Controllers\PDFController::class, 'generatePDF']);
Route::get('/generate-pdf-one/{id}', [App\Http\Controllers\PDFController::class, 'generatePDFOneTransaction'])->name('generate.pdf.one')->middleware('auth');
Route::get('/generate-pdf-all/{id}', [App\Http\Controllers\PDFController::class, 'generatePDFAllTransaction'])->name('generate.pdf.all')->middleware('auth');

// productBundle
Route::get('/listProductBundle', [App\Http\Controllers\PackageController::class, 'index'])->middleware('auth');
Route::post('/getProductBundles', [App\Http\Controllers\PackageController::class, 'getAll'])->middleware('auth');
Route::post('/addProductBundle', [App\Http\Controllers\PackageController::class, 'addItem'])->middleware('auth');
Route::post('/getProductBundle', [App\Http\Controllers\PackageController::class, 'getItem'])->middleware('auth');
Route::post('/updateProductBundle', [App\Http\Controllers\PackageController::class, 'updateItem'])->middleware('auth');
Route::post('/deleteProductBundle', [App\Http\Controllers\PackageController::class, 'deleteItem'])->middleware('auth');


//REPORTING SALES
Route::get('/sales/report', [App\Http\Controllers\SalesReportController::class, 'index'])->middleware('auth');
Route::post('/sales/getReport', [App\Http\Controllers\SalesReportController::class, 'getAll'])->middleware('auth');
Route::post('/sales/getReport/download', [App\Http\Controllers\SalesReportController::class, 'download'])->middleware('auth');

Route::get('/incentive/report', [App\Http\Controllers\IncentiveReportController::class, 'index'])->middleware('auth');
Route::post('/incentive/getReport', [App\Http\Controllers\IncentiveReportController::class, 'getAll'])->middleware('auth');
Route::post('/incentive/getReport/summary', [App\Http\Controllers\IncentiveReportController::class, 'getSummary'])->middleware('auth');
Route::post('/incentive/getReport/download', [App\Http\Controllers\IncentiveReportController::class, 'download'])->middleware('auth')->name('dwnld-inctv');

Route::get('/stock/report', [App\Http\Controllers\StockController::class, 'index'])->middleware('auth');
Route::post('/stock/getReport', [App\Http\Controllers\StockController::class, 'getAll'])->middleware('auth');
Route::post('/stock/getReport/download', [App\Http\Controllers\StockController::class, 'download'])->middleware('auth');
Route::post('/stock/getReport/summary', [App\Http\Controllers\StockController::class, 'getSummary'])->middleware('auth');


// salary
Route::get('/listSalary', [App\Http\Controllers\SalaryController::class, 'index'])->middleware('auth');
Route::post('/getSalarys', [App\Http\Controllers\SalaryController::class, 'getAll'])->middleware('auth');
Route::post('/addSalary', [App\Http\Controllers\SalaryController::class, 'addItem'])->middleware('auth');
Route::post('/getSalary', [App\Http\Controllers\SalaryController::class, 'getItem'])->middleware('auth');
Route::post('/updateSalary', [App\Http\Controllers\SalaryController::class, 'updateItem'])->middleware('auth');
Route::post('/deleteSalary', [App\Http\Controllers\SalaryController::class, 'deleteItem'])->middleware('auth');

// Other Cost
Route::get('/listCost', [App\Http\Controllers\CostController::class, 'index'])->middleware('auth');
Route::post('/getCosts', [App\Http\Controllers\CostController::class, 'getAll'])->middleware('auth');
Route::post('/addCost', [App\Http\Controllers\CostController::class, 'addItem'])->middleware('auth');
Route::post('/getCost', [App\Http\Controllers\CostController::class, 'getItem'])->middleware('auth');
Route::post('/updateCost', [App\Http\Controllers\CostController::class, 'updateItem'])->middleware('auth');
Route::post('/deleteCost', [App\Http\Controllers\CostController::class, 'deleteItem'])->middleware('auth');