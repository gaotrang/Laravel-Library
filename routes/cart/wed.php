<?php


use App\Http\Controllers\Client\CartController;
use App\Mail\OrderEmail;
use Illuminate\Support\Facades\Mail;
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


//Cart
Route::prefix('cart/')->name('cart.')->middleware('auth')->group(function(){
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('add-to-cart/{productId}/{qty?}', [CartController::class, 'addProductToCart'])->name('add-to-cart');
    Route::get('delete-product-in-cart/{productId}', [CartController::class, 'deleteProductInCart'])->name('delete-product-in-cart');
    Route::get('update-product-in-cart/{productId}/{qty?}', [CartController::class, 'updateProductInCart'])->name('update-product-in-cart');
    Route::get('delete-cart', [CartController::class, 'deleteCart'])->name('delete-cart');
    
    Route::post('place-order', [CartController::class, 'placeOrder'])->name('place-order');



    });
    // Route::get('test-send-mail', function(){
    //     Mail::to('ttruonggiangbk@gmail.com')->send(new OrderEmail());


   

// });



