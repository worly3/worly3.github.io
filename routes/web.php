<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/aboutus', [HomeController::class, 'aboutus'])->name('aboutus'); 
Route::get('/contactus', [HomeController::class, 'contactus'])->name('contactus');
// Route::get('/', [LoginController::class, 'index'])->name('portal'); 
