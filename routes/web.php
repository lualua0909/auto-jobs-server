<?php

use App\Http\Controllers\AuthenticateController;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyType;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::post('graphql/login', [AuthenticateController::class, 'authenticate']);

Route::get('test-1', function () {
    $user = User::with(['ward:id,name', 'district:id,name', 'province:id,name'])->first();
    return $user;
});

Route::get('test-role', function () {
    $role = Role::create(['name' => 'user']);
    return 111;
});

Route::get('clear-cache', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:cache');

    echo date('Y-m-d H:i:s');
});
