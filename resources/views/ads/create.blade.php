@extends('layouts.user')

@section('title', 'Post Ad')
@section('page-title', 'Post a New Ad')

@section('content')
<div class="card" style="max-width:700px;">
  <div class="card-header bg-primary text-white"><strong>Create Ad</strong></div>
  <div class="card-body">
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form method="POST" action="{{ route('ads.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group mb-3">
        <label for="title">Title<span class="text-danger">*</span></label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" required>
      </div>
      <div class="form-group mb-3">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
      </div>
      <div class="form-group mb-3">
        <label for="price">Price (optional)</label>
        <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" class="form-control">
      </div>
      <div class="form-group mb-4">
        <label for="photos">Photos (first becomes thumbnail)</label>
        <input type="file" id="photos" name="photos[]" multiple accept="image/*" class="form-control-file">
        <small class="form-text text-muted">You can select multiple images. Max 2MB each.</small>
      </div>
      <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Publish Ad</button>
      <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
