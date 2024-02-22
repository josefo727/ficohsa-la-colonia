<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Josefo727\GeneralSettings\Http\Controllers\Admin\GeneralSettingController;

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

Route::get('/', function () {
    if (app()->environment('production')) {
        $url = 'https://www.diunsa.hn/';

        return redirect()->away($url);
    }

    return view('welcome');
});

Auth::routes([
    'register' => false,
    'confirm' => false,
]);

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', App\Http\Controllers\OrderController::class)->name('orders.index');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/admin/general-settings', GeneralSettingController::class)
        ->names([
            'index' => 'admin.general-settings.index',
            'create' => 'admin.general-settings.create',
            'store' => 'admin.general-settings.store',
            'show' => 'admin.general-settings.show',
            'edit' => 'admin.general-settings.edit',
            'update' => 'admin.general-settings.update',
            'destroy' => 'admin.general-settings.destroy',
        ]);

});
