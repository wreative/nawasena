<?php

use Illuminate\Support\Facades\Route;

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
    return view('pages.home');
});

Route::get('/version', function () {
    $appVersion = config('veyaz.app_ver');
    $apiVersion = config('veyaz.api_ver');
    $laravelVersion = app()->version();
    $phpVersion = phpversion();
    return [
        'App' => $appVersion,
        'Laravel' => $laravelVersion,
        'PHP' => $phpVersion,
        'API' => $apiVersion,
    ];
});