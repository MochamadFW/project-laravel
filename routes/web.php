<?php

use App\Http\Controllers\CharChecker;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('char_checker.index');
});

Route::post('/check', [CharChecker::class, "check"]);