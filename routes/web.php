<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;
use App\Livewire\ImageUpload;


Route::get('/', function () {
    return view('welcome');
});

	
Route::get('/image-upload', ImageUpload::class)->name('posts');




// Route::get('/user-token/{user_id}', [TokenController::class,'createToken'])->name('user.token');
// Route::post('/user-token', [TokenController::class,'createToken'])->name('user.token');
// Route::get('/user-get-token/{user_id}', [TokenController::class,'decryptToken'])->name('user.get.token');
// Route::post('/user-get-token', [TokenController::class,'decryptToken'])->name('user.get.token');



