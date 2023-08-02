<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Validation\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Product::take(5)->get();
        // return response()->json(['message' => 'ok', 'datas' => $datas], 200);
        return ProductResource::collection($datas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        //validate
        $data = $request->validated();

        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
        ]);
        if($product){
            return ProductResource::make($product);

        }
        return response()->json(['error' => 'Something went wrong'], 400);
        // $errors = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'price' => 'required'
        // ]);
        // if($errors->fails()){
        //     return response()->json(['message' => 'NOT OK', 'errors' => $errors->errors()], 400);
        // }
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update(['name' => $request->name]);
        return ProductResource::make($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //soft delete
        $product->delete();
        //force delete
        // $product->forceDelete();

        return response()->json(['message' => 'Delete Success'], 201);
        
    }
}
