<?php

use App\Http\Controllers\Test;
use App\Http\Controllers\V1\DownloadController;
use App\Http\Controllers\V1\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [UploadController::class, "index"])->name("index");
Route::post("/upload", [UploadController::class, "upload"])->name("upload");
Route::get("/download/{year}/{month}/{day}/{dayName}/{hour}/{minute}/{second}/{filename}", [DownloadController::class, "download"])->name("download");
