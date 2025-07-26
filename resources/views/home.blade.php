@extends('layouts.user')

@section('title', 'Dashboard')

@section('page-title', 'User Dashboard')

@section('content')
<div class="card">
  <div class="card-header bg-primary text-white">
    <h3>Welcome, {{ auth()->user()->name }}</h3>
  </div>
  <div class="card-body">
    <p>This is your user dashboard. Use the sidebar navigation to explore options like posting ads or viewing your profile.</p>
  </div>
</div>
@endsection