@extends('client.layout.master')

@section('content')
<div id="login">
    <h3 class="text-center text-white pt-5">Login form</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="{{ route('nguoidung.dangnhap') }}" method="POST">
                        @csrf
                        <h3 class="text-center text-info">Login</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Email:</label><br>
                            <input type="email" name="email" id="email" class="form-control">
                            @error('email')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror

                            @if($message = Session::get('error'))
                                <div class="alert-danger">{{$message}}</div>
                            @endif
                            
                        </div>
                        <div class="form-group">
                            <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                            <input type="submit" name="submit" class="btn btn-info btn-md" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
