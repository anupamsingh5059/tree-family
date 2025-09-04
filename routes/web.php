<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyTreeController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomController;

Route::get('/dash', function () {
    return view('dashboard.bashbord');
});
// routes/web.php
use App\Http\Controllers\MemberController;
use App\Http\Middleware\Admin;

// Route::get('/family/{id}', [MemberController::class, 'getRelations']);
Route::get('/ss', [MemberController::class, 'index']);
// Route::get('/member/{id}', [MemberController::class, 'show']);

Route::get('/tree/{id}', [MemberController::class,'getTree']);

Route::get('/', function() {
    // Anupam ka id = 1
    return view('tree');
});

// Registration
Route::get('register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

// Update password (for logged in users)
Route::post('update-password', [AuthController::class, 'updatePassword'])->name('password.update.loggedin');

// start login for admin route




// Show admin login form
Route::get('admin', [AuthController::class, 'adminlogin'])->name('admin.login');

// Handle login POST request
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'admin'], function () {
Route::get('/get-users', [MemberController::class, "familytree"]);
Route::get('/dashboard', [FamilyTreeController::class, 'index']);
Route::post('/store', [FamilyTreeController::class, 'store'])->name('store');
Route::get('/fetchall-tree', [FamilyTreeController::class, 'fetchAll'])->name('fetchAll');
Route::delete('/delete', [FamilyTreeController::class, 'delete'])->name('delete');
Route::get('/edit', [FamilyTreeController::class, 'edit'])->name('edit');
Route::post('/update', [FamilyTreeController::class, 'update'])->name('update');


});


// End login admin route



Route::get('custome-login', [CustomController::class, "Customelogin"]);
Route::post('custome-post', [CustomController::class, "CustomePost"])->name('users.store');


