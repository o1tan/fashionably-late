<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
Route::post('/thanks', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::delete('/delete', [AdminController::class, 'destroy'])->name('admin.destroy');