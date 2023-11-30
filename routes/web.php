<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('index');
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    //登録処理
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    // 削除処理
    Route::post('/itemDelete/{id}', [App\Http\Controllers\ItemController::class, 'destroy']);
    //詳細画面
    Route::get('/detail/{id}', [App\Http\Controllers\ItemController::class, 'detail']);
    //編集画面
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit']);
    Route::post('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit']);
    //ブックマーク関連
    Route::post('/{item}/nice', [App\Http\Controllers\NiceController::class, 'store'])->name('nice.store');
    Route::delete('/{item}/unnice', [App\Http\Controllers\NiceController::class, 'destroy'])->name('nice.destroy');
    Route::get('/nices', [App\Http\Controllers\ItemController::class, 'nice_items'])->name('nices');

    
    //検索処理
    Route::get('/search', [App\Http\Controllers\ItemController::class, 'search'])->name('search');

    //並び替え処理
    Route::get('/select', [App\Http\Controllers\ItemController::class, 'select'])->name('select');

});
