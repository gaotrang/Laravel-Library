@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    @if( session('message'))
        <div class="alert-success">
            {{ session('message') }}
        </div>
    @endif

</div>
<section class="content">
    <div class="container-fluid">
      <button>Create Product Category</button>
    </div>
@endsection
