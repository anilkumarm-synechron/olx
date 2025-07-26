@extends('layouts.auth')

@section('title', 'Register')

@section('page-title', 'Create a new account')

@section('content')
<div class="card card-outline card-primary mx-auto" style="max-width: 400px; margin-top:50px;">
  <div class="card-header text-center">
    <h1><b>Register</b></h1>
  </div>
  <div class="card-body">
    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="input-group mb-3">
        <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-user"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
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
      <div class="input-group mb-3">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
    <p class="mt-3 text-center">
      Already have an account? <a href="{{ route('login') }}">Login here</a>
    </p>
  </div>
</div>
@endsection