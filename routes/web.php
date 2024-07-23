<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

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

Route::group(['middleware' => 'web'], function () {
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
Route::group(['middleware' => 'web'], function () {
    Route::get('employee', [EmployeeController::class, 'index'])->name('employee');
    Route::post('insert/employee', [EmployeeController::class, 'store'])->name('insert.employee');
    Route::get('edit/employee/{id}', [EmployeeController::class, 'edit'])->name('edit.employee');
    Route::post('update/employee', [EmployeeController::class, 'update'])->name('update.employee');
    Route::get('delete/employee/{id}', [EmployeeController::class, 'delete'])->name('delete.employee');
});
