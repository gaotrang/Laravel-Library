@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <h1>Update Product</h1>
      </div>
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('admin.product.update',['product' => $product->id]) }}" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input value="{{ $product->name }}" type="text" class="form-control" id="name" name="name" placeholder="Name">
                  </div>
                  <div>
                    @error('name')
                        <span style="color:red">{{ $message }}</span>
                    @enderror
                </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Slug</label>
                    <input value="{{ $product->slug }}" type="text" class="form-control" id="slug" name="slug" placeholder="Slug">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Price</label>
                    <input value="{{ $product->price }}" type="number" class="form-control" id="price" name="price" placeholder="Price">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Discount Price</label>
                    <input value="{{ $product->discount_price }}" type="number" class="form-control" id="discount_price" name="discount_price" placeholder="Discount price">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    {{-- <input type="text" class="form-control" id="description" placeholder="Description"> --}}
                    <textarea value="{{ $product->description }}" id="description" name="description"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Short Description</label>
                    <input value="{{ $product->short_description }}" type="text" class="form-control" id="short_description" name="short_description" placeholder="Short Description">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Information</label>
                    <input value="{{ $product->information }}" type="text" class="form-control" id="information" name="information" placeholder="Information">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Quantity</label>
                    <input value="{{ $product->qty }}" type="number" class="form-control" id="qty" name="qty" placeholder="Quantity">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Shipping</label>
                    <input value="{{ $product->shipping }}" type="text" class="form-control" id="shipping" name="shipping" placeholder="Shipping">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Weight</label>
                    <input value="{{ $product->weight }}" type="text" class="form-control" id="weight" name="weight" placeholder="Weight">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Image_URL</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input value="{{ $product->image_url }}" type="file" class="custom-file-input" id="image_url" name="image_url">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-select form control">
                      <option value="">-----Please Select-----</option>
                      <option @if($product->status) selected @endif value="1">Show</option>
                      <option @if(!$product->status) selected @endif value="0">Hide</option>
                    </select>
                  </div>
                  <div class="form-check">
                    <label for="product_category_id">Product Category</label>
                    <select name="product_category_id" id="product_category_id" class="form-select form control">
                      <option value="">-----Please Select-----</option>
                            @foreach ($productCategories as $productCategory)
                                <option @if($product->product_category_id === $productCategory->id) selected @endif value="{{ $productCategory->id }}" >{{ $productCategory->name }}</option>
                            @endforeach
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="create">Update</button>
                </div>
              </form>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('js-custom')
<script>
    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection
