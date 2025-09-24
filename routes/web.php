<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyTreeController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\CustomtreeController;
use App\Http\Controllers\FamilyController;
use Illuminate\Support\Str;
use App\Models\Member;
Route::get('insert', function() {
    $members = Member::all(); // all members

    foreach($members as $member) {
        $member->slug = Str::slug($member->name);
        $member->save();
    }

    return "Slugs updated successfully!";
});

Route::get('/family-one/{id}', [CustomtreeController::class, 'getFamilyOne']);

Route::get('/dash', function () {
    return view('dashboard.bashbord');
});
// routes/web.php
use App\Http\Controllers\MemberController;
use App\Http\Middleware\Admin;

// Route::get('/family/{id}', [MemberController::class, 'getRelations']);
Route::get('/ss', [MemberController::class, 'index']);
// Route::get('/member/{id}', [MemberController::class, 'show']);

Route::get('/tree/{slug}/{relation?}', [MemberController::class, 'viewTree']);
Route::get('/api/tree/{slug}', [MemberController::class, 'getTree']);


// Root page (optional, loads tree for default member id = 1)
Route::get('/', function() {
    $defaultMember = Member::first(); // first member as default
    return view('tree', [
        'default_name' => $defaultMember ? $defaultMember->name : ''
    ]);
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


// Route::get('')
Route::get('custome-login', [CustomController::class, "Customelogin"]);
Route::post('custome-post', [CustomController::class, "CustomePost"])->name('users.store');




Route::get('tree-new', [FamilyController::class, "family"]);


