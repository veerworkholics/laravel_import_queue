<?php
   
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\ProductImportController;
  
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job', function () {
    Artisan::call('queue:listen');
    return 'Job Started....';
});
  

    Route::get('all-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    //$exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    echo 'done';
    });

Route::get('products-import', [ProductImportController::class, 'index'])->name('products.import.index');
Route::post('products-import', [ProductImportController::class, 'store'])->name('products.import.store');