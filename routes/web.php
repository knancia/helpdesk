<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ABRIR CHAMADO
use App\Http\Controllers\AbrirChamado;
use App\Http\Controllers\AcompanharChamado;
use App\Http\Controllers\ListarChamados;

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

Route::get('/', function () {
    return redirect()->route('home');
});


// Rotas sem autenticação
Route::get('/home', function () { return Inertia::render('Home'); })->name('home');
Route::get('/abrirChamado', [AbrirChamado::class, 'index'])->name('abrirChamado');
Route::post('/abrirChamado/store', [AbrirChamado::class, 'store'])->name('abrirChamado.store');

Route::get('/acompanharChamado/{helpdesk?}', [AcompanharChamado::class, 'index'])->name('acompanharChamado');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::group(['prefix' => 'listarChamados'], function () {
        Route::get('/', [ListarChamados::class, 'index'])->name('listarChamados.index');
        Route::post('/store', [ListarChamados::class, 'store'])->name('listarChamados.store');
        Route::get('/chamado/{id}', [ListarChamados::class, 'getPhotos'])->name('listarChamados.chamado');
    });
});