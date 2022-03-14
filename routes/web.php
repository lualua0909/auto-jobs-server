<?php

use App\Http\Controllers\AuthenticateController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::post('graphql/login', [AuthenticateController::class, 'authenticate']);

Route::get('test-1', function () {
    $user = User::where('id', 5)
        ->with('created_by_user:id,name,created_at')
        ->with('ward:id,name,created_at')
        ->first();
    return $user;
});

Route::get('test-role', function () {
    $role = Role::create(['name' => 'user']);
    return 111;
});
