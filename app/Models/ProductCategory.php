<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_category'; 
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class)->foreignKey('product_category_id');
    }
}
