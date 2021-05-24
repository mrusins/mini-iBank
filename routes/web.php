<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\FinToolsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Register;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\ConfirmsPasswords;



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

session_start();

Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('index');

});



//Route::post('/register', [Register::class, 'register']);
Route::middleware(['auth:sanctum', 'verified'])->get('/main', [HomeController::class, 'index'])->name('index');
Route::middleware(['auth:sanctum', 'verified'])->post('/main', [HomeController::class, 'indexRedirect']);
Route::middleware(['auth:sanctum', 'verified'])->post('/confirmPayment', [HomeController::class, 'confirmPayment']);
Route::middleware(['auth:sanctum', 'verified'])->post('/cancelPayment', [HomeController::class, 'cancelPayment']);

Route::middleware(['auth:sanctum', 'verified'])->get('/tools', [FinToolsController::class, 'index'])->name('tools');
Route::middleware(['auth:sanctum', 'verified'])->get('/showrates', [FinToolsController::class, 'showRates']);

Route::middleware(['auth:sanctum', 'verified'])->post('/addstock', [FinToolsController::class, 'addStock'])->name('addStock');



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');








