@extends('layouts.auth')

@section('title', 'Login')

@section('page-title', 'Login to your account')

@section('content')
<div class="card card-outline card-primary mx-auto" style="max-width: 400px; margin-top:50px;">
  <div class="card-header text-center">
    <h1><b>Login</b></h1>
  </div>
  <div class="card-body">
    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-8">
          <div class="icheck-primary">
            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember"> Remember Me </label>
          </div>
        </div>
        <div class="col-4">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
      </div>
    </form>
    <p class="mt-3 mb-1">
      <a href="{{ route('password.request') }}">Forgot password?</a>
    </p>
    <p class="mb-0 text-center">
      Don't have an account? <a href="{{ route('register') }}" class="text-center">Register here</a>
    </p>
  </div>
</div>
@endsection