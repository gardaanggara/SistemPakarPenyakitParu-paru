<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::prefix('roles')->group(function(){
    Route::get('/data', [RolesController::class, 'index'])->name('dashboardRoles');
    Route::get('/api/data', [RolesController::class, 'getData'])->name('apiDataRoles');
    Route::get('/api/data/{id}', [RolesController::class, 'getRoleById']); 
    Route::post('/store/{id?}', [RolesController::class, 'storeOrUpdate'])->name('storeRoles');
    Route::delete('/{id?}', [RolesController::class, 'destroy'])->name('deleteRoles');
});

require __DIR__.'/auth.php';
