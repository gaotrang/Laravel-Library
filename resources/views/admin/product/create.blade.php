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
        <h1>Create Product</h1>
      </div>
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Slug</label>
                    <input type="text" class="form-control" id="slug" placeholder="Slug">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Price</label>
                    <input type="number" class="form-control" id="price" placeholder="Price">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Discount Price</label>
                    <input type="number" class="form-control" id="discount_price" placeholder="Discount price">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <input type="text" class="form-control" id="description" placeholder="Description">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Short Description</label>
                    <input type="text" class="form-control" id="short_description" placeholder="Short Description">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Information</label>
                    <input type="text" class="form-control" id="information" placeholder="Information">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Quantity</label>
                    <input type="number" class="form-control" id="quantity" placeholder="Quantity">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Shipping</label>
                    <input type="text" class="form-control" id="shipping" placeholder="Shipping">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Weight</label>
                    <input type="text" class="form-control" id="weight" placeholder="Weight">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Image_URL</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>

                    </div>
                  </div>
                  <div class="form-check">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-select form control">
                      <option value="">-----Please Select-----</option>
                      <option value="1">Show</option>
                      <option value="0">Hide</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Create</button>
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