@extends('client.layout.master')

@section('content')
    {{-- <div class="container">
        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li><span style="color:red;">{{ $error }}</span></li>
                    @endforeach
                </ul>
            </div>
            @endif
    </div> --}}
      
          <!-- Login Form -->
          <form action="{{route ('nguoidung.dangki')}}" method="POST"
          style="    display: flex;
          flex-direction: column;
          margin: 0 20%;">
            {{-- chong CSRF Attak --}}
            @csrf
            {{-- chong CSRF Attack --}}
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
            @error('email')
                <div class="alert-danger">{{ $message }}</div>
            @enderror

            <input type="email" id="email" class="fadeIn second" name="email" placeholder="email" value="{{ old('email') }}">
            @error('email')
                <div class="alert-danger">{{ $message }}</div>
            @enderror
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
            @error('password')
            <div class="alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" name="register"> Register</button>
          </form>


@endsection