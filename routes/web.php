<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ImageUpload;

Route::get('/', function () {
    return view('welcome');
});


	
Route::get('/image-upload', ImageUpload::class)->name('posts');