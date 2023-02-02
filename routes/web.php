<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    logger()
//        ->channel('telegram')
//        ->debug(request()->url());
    return view('welcome');
});
