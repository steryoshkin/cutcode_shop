<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    logger()
//        ->channel('telegram')
//        ->debug(request()->url());
//    Product::query()
//        ->select(['id', 'title', 'brand_id'])
//        ->with(['categories', 'brand'])
//        ->where('id', 1)
//        ->get();
    $slug = 'ea-qui-0';

    dump(Product::query()
        ->select('slug')
        ->where('slug', 'LIKE', $slug.'%')
        ->count());

    return view('welcome');
});
