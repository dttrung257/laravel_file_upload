<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [ImageController::class, 'upload'])->name('upload');
Route::post('/upload', [ImageController::class, 'uploadPost'])->name('upload.post');
Route::get('/images', [ImageController::class, 'index'])->name('images');
