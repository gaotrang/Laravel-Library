<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository{
    public function getTopProducts($number = 5){
        return Product::latest()->take($number)->get();
    }
}


?>