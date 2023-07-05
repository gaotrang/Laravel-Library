<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    public function store(StoreProductCategoryRequest $request){
        // dd($request->all());
        //Validate data from client
    //     $request->validate([
    //         'name' => 'required|min:3|max:255|string|unique:product_category,name',
    //         // 'slug' => 'required|min:3|max:255|string',
    //         'status' => 'required|boolean'
    //     ],
    // [
    //     'name.required' => 'Category Name is required',
    //     'slug.required' => 'Slug Category is required',
    //     'status.required' => 'Status is required'
    // ]);
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
    return redirect()->route('admin.product_category.list')->with('message',$message);
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

    public function index(Request $request){
        //SQL RAW
        // $page = $request->page ?? 1;

        // $itemPerPage = config('myconfig.item_per_page');
        // $pageFirst = ($page-1) * $itemPerPage;
        // //SQL RAW
        // $query = DB::select('select * from product_category');
        // $numberOfPage = ceil(count($query)/$itemPerPage);

        // $productCategories = DB::select("select * from product_category limit $pageFirst, $itemPerPage");

        // return view('admin.product_category.list', compact('productCategories', 'numberOfPage'));

        //QUERY BUILDER
        //paginate chi dung cho Query Builder and pp 3 khong dung cho SQL RAW

        $productCategories = DB::table('product_category')->paginate(config('myconfig.item_per_page'));
        return view('admin.product_category.list',compact('productCategories'));
    }

    public function detail($id){
        $productCategory = DB::select('select * from product_category where id = ?', [$id]);
        return view('admin.product_category.detail', ['productCategory'=> $productCategory]);
    }

    public function update(UpdateProductCategoryRequest $request, string $id){
        //validate input from user
        // $request->validate([
        //     'name' => 'required|min:3|max:255|string|unique:product_category,name,'.$id,
        //     'status' => 'required|boolean'
        // ],
        // [
        //     'name.required' => 'Category Name is required',
        //     'slug.required' => 'Slug Category is required',
        //     'status.required' => 'Status is required'
        // ]);

        //Update into DB - SQL Raw
        // $check = DB::update('Update product_category SET name = ?, slug = ?, status = ? where id = ?', [$request->name, $request->slug, $request->status, $request->id]);

        //Query Builder

        $check = DB::table('product_category')
        ->where('id', $id)
        ->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ]);

        $message = $check ? 'success' : 'failed';
        return redirect()->route('admin.product_category.list')->with('message',  $message);

    }

    public function destroy($id){
        //SQL RAW
        // $check = DB::delete('delete from product_category where id = ?', [$id]);

        //Query Builder
        $check = DB::table('product_category')->where('id', $id)->delete();

        $message = $check ? 'delete success' : 'failed';
        return redirect()->route('admin.product_category.list')->with('message', $message);
    }


}
