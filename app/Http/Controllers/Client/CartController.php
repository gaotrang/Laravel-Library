<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function index(){
        // dd(session()->get('cart'));
        $cart = session()->get('cart') ?? [];
        return view('client.pages.shoping-cart', compact('cart'));
    }

    public function addProductToCart($productId, $qty = 1)
    {
        $product = Product::find($productId);
        if($product){
                $cart = session()->get('cart') ?? [];

                $imageLink = is_null($product->image_url) || !file_exists('images/' . $product->image_url) ? 'default_image.jpg' : $product->image_url;
                $cart[$product->id] = [
                    'name' => $product->name,
                    'price' => number_format($product->price, 2),
                    'image_url' => asset('images/'.$imageLink),
                    'qty' => ($cart[$productId]['qty'] ?? 0) + $qty
                ];
                //Add cart into session
                session()->put('cart', $cart);

                $total_product = count($cart);
                $total_price = 0;

                foreach($cart as $item){
                    $total_product = $item['qty'] * $item['price'];
                    $total_price += $total_price;
                }

            return response()->json(['message' => 'Add product success!', 'total_product' => $total_product, 'total_price'=> $total_price]);
        }else{
            return response()->json(['message' => 'Add product failed!'], Response::HTTP_NOT_FOUND);
        }
    }
    public function calculateTotalPrice(array $cart){
        $total_price = 0;

        foreach($cart as $item){
            $total_price = $item['qty'] * $item['price'];
    }
    return number_format($total_price, 2);

    }

    public function deleteProductInCart($productId){
        $cart = session()->get('cart') ?? [];
        if(array_key_exists($productId, $cart)){
            unset($cart[$productId]);
            session()->get('cart', $cart);
        }else{
            return response()->json(['message' => 'Add product failed!'], Response::HTTP_NOT_FOUND);
        }
        $total_product = count($cart);
        $total_price = $this->calculateTotalPrice($cart);
        return response()->json(['message' => 'Remove success!', 'total_product' => $total_product, 'total_price'=> $total_price]);
    }


    public function updateProductInCart($productId, $qty){
        $cart = session()->get('cart') ?? [];
        if(array_key_exists($productId, $cart)){
            $cart[$productId]['qty'] = $qty;
            if(!$qty){
                unset($cart[$productId]);
            }
            session()->get('cart', $cart);
        }

        $total_product = count($cart);
        $total_price = $this->calculateTotalPrice($cart);
        return response()->json(['message' => 'Update success!', 'total_product' => $total_product, 'total_price'=> $total_price]);
    }

    public function deleteCart(){
        session()->put('cart', []);
        return response()->json(['message' => 'Delete Cart success!', 'total_product' => 0, 'total_price'=> 0]);
        
    }

}

