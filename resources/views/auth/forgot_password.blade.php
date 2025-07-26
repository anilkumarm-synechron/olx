@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('page-title', 'Reset Password')

@section('content')
<div class="card card-outline card-primary mx-auto" style="max-width: 400px; margin-top:50px;">
  <div class="card-header text-center">
    <h1><b>Forgot Password</b></h1>
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
    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Your email" value="{{ old('email') }}" required autofocus>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
    </form>
    <p class="mt-3 mb-0 text-center">
      <a href="{{ route('login') }}">Back to Login</a>
    </p>
  </div>
</div>
@endsection