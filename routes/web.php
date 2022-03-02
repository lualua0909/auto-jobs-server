<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test-role', function () {
    $role = Role::create(['name' => 'sylencer']);
    $permission = Permission::create(['name' => 'edit articles']);
    $role->givePermissionTo($permission);
    return 111;
});

Route::post('graphql/login', [AuthenticateController::class, 'authenticate']);