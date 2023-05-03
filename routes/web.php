<?php

use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('loan.index'));
});

Route::prefix('/loan')->group(function () {
    Route::get('/', [LoanController::class, 'index'])->name('loan.index');
    Route::get('/{id}', [LoanController::class, 'show'])->name('loan.show')->where('id', '[0-9]+');;
    Route::get('/create', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/create', [LoanController::class, 'store']);
});
