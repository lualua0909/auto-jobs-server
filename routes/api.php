<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Image;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/get_cmnd/{user_id}', function ($user_id) {
    // dd(storage_path("app\users\\$user_id\avatar.webp"));
    return Image::make(storage_path("app\users\\$user_id\avatar.webp"))->response();
});