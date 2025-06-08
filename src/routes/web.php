<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Models\Contact;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;


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

//お問い合わせフォーム（http://localhost/）
Route::get('/', [ContactController::class, 'index']);

//お問い合わせフォーム確認（http://localhost/confirm）
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::get('/confirm', function () {return redirect('/');});

//お問い合わせフォームサンクス（http://localhost/thanks）
Route::post('/store', [ContactController::class, 'store']);
Route::get('/thanks', [ContactController::class, 'thanks'])->name('thanks');

//編集機能
Route::post('/edit', function (Illuminate\Http\Request $request) {
    return redirect('/')
        ->withInput($request->all());
});

//管理画面（http://localhost/admin）
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/contacts/{id}', [AdminController::class, 'destroy'])->name('contacts.delete');
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
});

//ログアウト処理
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
