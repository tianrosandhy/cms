<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

Route::get('/', [Controller::class, 'index'])->name('index');
Route::get('/form', [Controller::class, 'form']);
Route::post('/form', [Controller::class, 'formPost']);
Route::match(['get', 'post'], 'datatable', [Controller::class, 'datatable'])->name('datatable-route');
Route::match(['get', 'post'], 'data-delete-route', [Controller::class, 'delete'])->name('data-delete-route');
Route::match(['get', 'post'], 'export', [Controller::class, 'export'])->name('datatable-export');
