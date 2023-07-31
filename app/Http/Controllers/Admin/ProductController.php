<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // // dd($request->all());
        // $keyword = $request->keyword;
        // $status = $request->status;
        // $amount_start = $request->amount_start;
        // $amount_end = $request->amount_end;
        // $sort = $request->sort;

        // //Eloquent
        // // $products = Product::paginate(config('myconfig.item_per_page'));
        // $filter = [];
        // if(!is_null($keyword)){
        //     $filter[] = ['name', 'like', '%'.$keyword.'%'];
        // }
        // if(!is_null($status)){
        //     $filter[] = ['status', $status];
        // }
        // // dd($filter);
        // if(!is_null($amount_start) && !is_null($amount_end)){
        //     $filter[] = ['price', '>=', $amount_start];
        //     $filter[] = ['price', '<=', $amount_end];
        // }

        // //Sort
        // $sortBy = ['id', 'desc'];
        // switch($sort){
        //     // case 0:
        //     //     $sortBy = ['id', 'desc'];
        //     //     break;
        //     case 1:
        //         $sortBy = ['price', 'asc'];
        //         break;
        //     case 2:
        //         $sortBy = ['price', 'desc'];
        //         break;
        // }

        // $products = Product::where($filter)->orderBy($sortBy[0], $sortBy[1])->paginate(config('myconfig.item_per_page'));


        // $products = Product::query();
        // if(is_null($keyword)){
        //     $products = Product::paginate(config('myconfig.item_per_page'));
        // }else{
        //     $products = Product::where('name', 'like', '%'.$keyword.'%')->paginate(config('myconfig.item_per_page'));
        // }

        //Query Builder
        //Select product.*, product_category.name
        //FROM product INNER JOIN product_category
        // ON product_category.id = product.product_category_id;

        // $products = DB::table('product')
        // ->join('product_category', 'product_category.id', '=', 'product.product_category_id')
        // ->select('product.*', 'product_category.name as product_category_name')
        // ->paginate(config('myconfig.item_per_page'));

        $pipelines = [
            \App\Filters\ByKeyWord::class,
            \App\Filters\ByStatus::class,
            \App\Filters\ByMinMax::class,
        ];

        //withTrashed() hàm để lấy all record include record đã xóa
        $pipeline = Pipeline::send(Product::query()->withTrashed())
        ->through($pipelines)
        ->thenReturn();

        $products = $pipeline->paginate(config('myconfig.item_per_page'));



        // dd($products->toSql());
        $max_price = Product::max('price');
        $min_price = Product::min('price');
        return view('admin.product.list', ['products' => $products, 'max_price' => $max_price, 'min_price' => $min_price]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //SQL Raw
        // $productCategories = DB::select('select * from product_category where status = 1');
        //Query Builder
        // $productCategories = DB::table('product_category')->where('status', 1)->get();

        //Eloquent
        // $productCategories = ProductCategory::all();

        $productCategories = ProductCategory::where('status', 1)->get();

        return view('admin.product.create')->with('productCategories', $productCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // dd($request);
        // $request->validate([
        //     'name' => 'required|min:3|max:255|string|unique:product,name',
        //     'product_category_id' => 'required'

        // ]);

        //SQL RAW
        // $check = DB::insert("insert into product ('name') values (?)", [$request->name]);
        // //query builder
        // $check = DB::table('product')->insert(['name' => $request->name]);
            $fileName = null;
            if($request->hasFile('image_url')){
                $originName = $request->file('image_url')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('image_url')->getClientOriginalExtension();
                $fileName = $fileName. '_' . time() . '.' . $extension;
                //$fileName = 09Car_01_123486123.jpg
                $request->file('image_url')->move(public_path('images'),$fileName);
            }

        $product = Product::create([
            //'key' => value
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'information' => $request->information,
            'qty' => $request->qty,
            'shipping' => $request->shipping,
            'weight' => $request->weight,
            'image_url' => $fileName,
            'status' => $request->status,
            'product_category_id' => $request->product_category_id

        ]);
        // dd($product);

        $message = $product ? 'Create Product Success' : 'Create Product Failed';
        return redirect()->route('admin.product.index')->with('message',$message);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        	//SQL Raw
            // $product = DB::select('select * from product where id = ?', [$id]);
            //Query Builder
            // $product = DB::table('product')->where('id', $id)->first();
            //Eloquent
            // $product = Product::find($id);
            $productCategories = ProductCategory::where('status', 1)->get();

            return view('admin.product.edit', ['product' => $product, 'productCategories' => $productCategories]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //validate
        // $request->validate([
        //     'name' => 'required',
        //     'product_category_id' => 'required'
        // ]);
        // $product = Product::find($id);

        $fileName = $product->image_url;

        if($request->hasFile('image_url')){
            $originName = $request->file('image_url')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image_url')->getClientOriginalExtension();
            $fileName = $fileName. '_' . time() . '.' . $extension;
            //$fileName = 09Car_01_123486123.jpg
            $request->file('image_url')->move(public_path('images'),$fileName);

            //Remove old image
            if(!is_null($product->image_url) && file_exists("images/".$product->image_url)){
                unlink("images/".$product->image_url);
            }

        }
        $check = $product->update([
            //'key' => value
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'information' => $request->information,
            'qty' => $request->qty,
            'shipping' => $request->shipping,
            'weight' => $request->weight,
            'image_url' => $fileName,
            'status' => $request->status,
            'product_category_id' => $request->product_category_id
        ]);

        $message = $check ? 'Update Product Success' : 'Update Product Failed';
        return redirect()->route('admin.product.index')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // $product = Product::find($id);
        $check = $product->delete();

        $message = $check ? 'delete success' : 'delete failed';

        return redirect()->route('admin.product.index')->with('message', $message);
    }

    public function restore(Product $product){
        $product = Product::withTrashed()->find($product);
        // $product->deleted_at = null;
        // $product->save;

        $product->restore();
        return redirect()->route('admin.product.index')->with('message', 'Restore success');
    }


    public function uploadImage(Request $request){
        if($request->hasFile('upload')){
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName. '_' . time() . '.' . $extension;
            
            $request->file('upload')->move(public_path('images'),$fileName);

            $url = asset('images/'. $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
}
