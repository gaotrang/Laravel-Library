<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        //Eloquent
        // $products = Product::orderBy('id', 'desc')->take(8)->get();

        $products = Product::latest()->take(8)->get();

        //Get 10 product category latest + child > 0
        // $productCategories = ProductCategory::latest()->get()->filter(function($productCategory){
        //     return $productCategory->products->count() > 0;
        // })->take(10);

        return view('client.pages.home',compact('products'));
    }

}
