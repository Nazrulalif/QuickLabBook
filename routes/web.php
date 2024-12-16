<?php

use App\Livewire\Home\Index;
use App\Livewire\Home\Syarat;
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

Route::get('/', Index::class);
Route::get('/syarat-peminjam', Syarat::class);
