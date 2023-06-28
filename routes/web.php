<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee', [EmployeeController::class, 'store']);
Route::get('/fetch-employee', [EmployeeController::class, 'fetchemployee']);
Route::get('/edit-employee/{id}', [EmployeeController::class, 'edit']);
Route::post('/update-employee/{id}', [EmployeeController::class, 'update']);
Route::delete('/delete-employee/{id}',[EmployeeController::class, 'destroy']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function (){

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);


});

Route::get('/users', function () {
    return view('users');
});
