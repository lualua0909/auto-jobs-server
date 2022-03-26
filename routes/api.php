<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Image;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/cmnd_front/{user_id}', function ($user_id) {
    return Image::make(storage_path("app/users/$user_id/cmnd_front.webp"))->response();
});

Route::get('/cmnd_back/{user_id}', function ($user_id) {
    return Image::make(storage_path("app/users/$user_id/cmnd_back.webp"))->response();
});