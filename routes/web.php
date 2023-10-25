<?php

use Illuminate\Support\Facades\Route;
use Stew\ImageUploader\Http\Controllers\DemoController;

Route::get('demo', [DemoController::class, 'index']);
Route::post('demo', [DemoController::class, 'store'])->name('store');
