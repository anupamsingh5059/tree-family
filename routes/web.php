<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyTreeController;
Route::get('/dash', function () {
    return view('dashboard.bashbord');
});
// routes/web.php
use App\Http\Controllers\MemberController;
// Route::get('/family/{id}', [MemberController::class, 'getRelations']);
Route::get('/ss', [MemberController::class, 'index']);
// Route::get('/member/{id}', [MemberController::class, 'show']);

Route::get('/tree/{id}', [MemberController::class,'getTree']);

Route::get('/', function() {
    // Anupam ka id = 1
    return view('tree');
});

Route::get('/get-users', [MemberController::class, "familytree"]);

Route::get('/admin', [FamilyTreeController::class, 'index']);
Route::post('/store', [FamilyTreeController::class, 'store'])->name('store');
Route::get('/fetchall-tree', [FamilyTreeController::class, 'fetchAll'])->name('fetchAll');
Route::delete('/delete', [FamilyTreeController::class, 'delete'])->name('delete');
Route::get('/edit', [FamilyTreeController::class, 'edit'])->name('edit');
Route::post('/update', [FamilyTreeController::class, 'update'])->name('update');