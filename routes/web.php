<?php

use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ClientProductController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//////////////////////////////////////
Route::get('admin', function(){
    return view('admin.layout.master');
})->name('admin')->middleware('auth.admin');

Route::get('cocacola', function(){
    return '<h1>Cocacola</h1>';
});
Route::get('chivas', function(){
    return '<h1>Chivas</h1>';
})->middleware('age.18');


Route::middleware('auth.admin')->name('admin.')->group(function (){

    Route::get('admin/blog', function(){
        return view('admin.pages.blog');
    })->name('blog');

    Route::get('admin/user', function(){
        return view('admin.pages.user');
    })->name('user');

    //----------Product---------//
    Route::get('admin/product', function(){
        return view('admin.pages.product');
    }) ->name('product');

    // Route::get('admin/product/create', [ProductController::class, 'create']) ->name('product.create');
    // Route::get('admin/product/store', [ProductController::class, 'store']) ->name('product.store');
    // Route::get('admin/product/show{id}', [ProductController::class, 'show']) ->name('product.show');
    // Route::get('admin/product/update', [ProductController::class, 'update']) ->name('product.update');
    // Route::get('admin/product/delete', [ProductController::class, 'delete']) ->name('product.delete');

    Route::resource('admin/product', ProductController::class);
    Route::post('admin/product/restore/{product}', [ProductController::class, 'restore'])->name('product.restore');



    //-------ProductCategory-------////
    Route::get('admin/product_category', [ProductCategoryController::class, 'index'])->name('product_category.list');

    Route::get('admin/product_category/create', function(){
        return view('admin.product_category.create');
    }) ->name('product_category.create');

    Route::post('admin/product_category/save', [ProductCategoryController::class, 'store'])->name('product_category.save');

    Route::post('admin/product_category/slug', [ProductCategoryController::class, 'getslug'])->name('product_category.slug');

    Route::get('admin/product_category/{id}', [ProductCategoryController::class, 'detail'])->name('product_category.detail');

    Route::post('admin/product_category/update/{id}', [ProductCategoryController::class, 'update'])->name('product_category.update');

    Route::post('admin/product_category/delete/{id}',[ProductCategoryController::class, 'destroy'])->name('product_category.delete');

});


//dung redirect()->route() thi phai co -> name()
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('product/{slug}', [ClientProductController::class, 'getProductBySlug'])->name('client.pages.shop-details');




//Cart
    Route::get('product/add-to-cart/{productId}/{qty?}', [CartController::class, 'addProductToCart'])->name('product.add-to-cart');


require __DIR__.'/cart/wed.php';
