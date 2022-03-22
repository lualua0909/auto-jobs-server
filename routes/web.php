<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scheduler', function() {
    Artisan::call('schedule:run');
});

Route::get('/access-file', function() {
        $fullpath="app/public/345.png";
        return response()->download(storage_path($fullpath), null, [], null);
});