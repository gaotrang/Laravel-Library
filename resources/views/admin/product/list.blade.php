@extends('admin.layout.master')
@section('content')

      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if( session('message'))
    <div class="alert-success">
        {{ session('message') }}
    </div>
@endif
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Product List</h1>
            <button>
                <a href="{{ route('admin.product.create')}}">Create Product</a>
            </button>
          </div>
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">id</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th>Price</th>
                      <th>Description</th>
                      <th>Image</th>
                      <th>Product Category Name</th>
                      <th style="width: 40px">Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name  }}</td>
                            <td>{{ $product->slug}}</td>
                            <td>{{ number_format( $product->price, 2)}}</td>
                            <td>{!! $product->description !!}</td>
                            <td>
                                @php
                                    $imageLink = (is_null($product->image_url)) || (!file_exists("images/".$product->image_url)) ? 'default_image.png' : $product->image_url;
                                @endphp
                                <img src="{{asset('images/'.$imageLink)}}" alt="{{ $product->name}}" width="200px", height="150px">
                            </td>
                            <td>{{ $product->category->name}}</td>
                            {{-- <td>{{ $product->status }}</td> --}}
                            
                            <td>
                                <a class="btn btn-{{ $product->status ? 'success' : 'danger' }}">
                                    {{ $product->status ? 'Show' : 'Hide' }}
                                </a>
                            </td>
                            <td>
                                <form method="post" action="{{ route('admin.product.destroy', ['product'=> $product->id]) }}">
                                    @csrf
                                    <a href="{{ route('admin.product.show', ['product'=> $product->id]) }}" class="btn btn-primary">Edit</a>
                                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No Product Category</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $products->links() }}
                {{-- <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  @for ($page = 1; $page <= $numberOfPage; $page++)
                        <li class="page-item"><a class="page-link" href="?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul> --}}
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
