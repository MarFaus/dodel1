<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('events.index'); });
Route::get('/events', function () { return view('events.index'); });
Route::get('/orders', function () { return view('orders.index'); });
Route::get('/analytics', function () { return view('analytics.index'); });
Route::get('/admin', function () { return view('admin.index'); });
Route::get('/scan', function () { return view('scan.index'); });
Route::get('/arch', function () { return view('arch.index'); });