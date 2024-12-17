<?php

use App\Livewire\Home\Borang;
use App\Livewire\Home\Hubungi;
use App\Livewire\Home\Index;
use App\Livewire\Home\SoalanLazim;
use App\Livewire\Home\Syarat;
use App\Livewire\Home\Tempahan;
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
Route::get('/tempahan', Tempahan::class);
Route::get('/hubungi', Hubungi::class);
Route::get('/soalan-lazim', SoalanLazim::class);
Route::get('/borang-pinjaman', Borang::class);
