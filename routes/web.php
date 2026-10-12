<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('events.index');
});

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::get('/orders/{number}/pdf', [PdfController::class, 'download'])->name('orders.pdf');

Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
Route::post('/analytics/refund/{number}', [AnalyticsController::class, 'refund'])->name('analytics.refund');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/events', [AdminController::class, 'storeEvent'])->name('admin.events.store');

Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
Route::post('/scan/verify', [ScanController::class, 'verify'])->name('scan.verify');