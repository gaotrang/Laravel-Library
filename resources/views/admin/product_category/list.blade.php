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
            <h1>Product Category List</h1>
            <button>
                <a href="{{ route('admin.product_category.create')}}">Create Product Category</a>
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
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th style="width: 40px">Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($productCategories as $productCategory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $productCategory->name  }}</td>
                            <td>{{ $productCategory->slug}}</td>
                            <td>{{ $productCategory->$product->count() }}</td>
                            {{-- <td>{{ $productCategory->status }}</td> --}}
                            <td>
                                <a class="btn btn-{{ $productCategory->status ? 'success' : 'danger' }}">
                                    {{ $productCategory->status ? 'Show' : 'Hide' }}
                                </a>
                            </td>
                            <td>
                                <form method="post" action="{{ route('admin.product_category.delete', ['id'=> $productCategory->id]) }}">
                                    @csrf
                                    <a href="{{ route('admin.product_category.detail', ['id'=> $productCategory->id]) }}" class="btn btn-primary">Edit</a>
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
                {{ $productCategories->links() }}
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
