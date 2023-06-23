<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    public function store(Request $request){
        // dd($request->all());
        //Validate data from client
        $request->validate([
            'name' => 'required|min:3|max:255|string',
            // 'slug' => 'required|min:3|max:255|string',
            'status' => 'required|boolean'
        ],
    [
        'name.required' => 'Category Name is required',
        'slug.required' => 'Slug Category is required',
        'status.required' => 'Status is required'
    ]);
    //SQL Raw
    // $check = DB::INSERT('insert into product_category(name, slug, status) values (?, ?, ?)', [$request->name, $request->slug, $request->status]);

    //Buoc1: Query Builder

    $check = DB::table('product_category')->insert([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'status' => $request->status
    ]);
    //
    // $lastId = DB::table('product_category')->insertGetId([
    //     'name' => $request->name,
    //     'slug' => $request->slug,
    //     'status' => $request->status
    // ]);

    // $slug = implode('-',explode('',$request->name));

    // dd($slug);
    $message = $check ? 'Create Product Category Success' : 'Create Product Category Failed';
    return redirect()->route('admin.product_category.create')->with('message',$message);
    // $message='';
    // if($check){
    //     $message = 'Create Product Category Success';
    // }else{
    //     $message = 'Create Product Category Failed ';
    // }
    // return redirect()->route('admin.product_category.list')->with('message',$message);

    }

    public function getSlug(Request $request){
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
    }

}
