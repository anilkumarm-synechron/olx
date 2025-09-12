@extends('layouts.user')

@section('title','Edit Ad')
@section('page-title','Edit Ad')

@section('content')
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger"><strong>Errors:</strong><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
<form method="POST" action="{{ route('ads.update',$ad) }}" enctype="multipart/form-data" class="mb-4">
  @csrf
  @method('PUT')
  <div class="card mb-3">
    <div class="card-header bg-primary text-white">Basic Info</div>
    <div class="card-body">
      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title',$ad->title) }}" required />
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description',$ad->description) }}</textarea>
      </div>
      <div class="form-group">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price',$ad->price) }}" />
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
          <option value="active" {{ $ad->status=='active'?'selected':'' }}>Active</option>
          <option value="inactive" {{ $ad->status=='inactive'?'selected':'' }}>Inactive</option>
        </select>
      </div>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header bg-secondary text-white">Existing Photos</div>
    <div class="card-body">
      <div class="d-flex flex-wrap" style="gap:12px;">
        @foreach($ad->photos as $p)
          <label style="display:block;">
            <div style="width:140px;height:105px;border:2px solid {{ $p->is_primary ? '#28a745':'#ccc' }};border-radius:6px;overflow:hidden;position:relative;cursor:pointer;">
              <img src="{{ str_ends_with(strtolower($p->path),'.txt') ? asset('placeholder.svg') : asset('storage/'.$p->path) }}" style="width:100%;height:100%;object-fit:cover;"/>
              <input type="radio" name="primary_photo_id" value="{{ $p->id }}" style="position:absolute;top:4px;left:4px;" {{ $p->is_primary?'checked':'' }} />
            </div>
          </label>
        @endforeach
        @if(!$ad->photos->count())<p class="text-muted">No photos yet.</p>@endif
      </div>
      <small class="text-muted d-block mt-2">Select a photo to mark as primary.</small>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header bg-info text-white">Add New Photos</div>
    <div class="card-body">
      <input type="file" name="photos[]" multiple accept="image/*" class="form-control" />
      <small class="form-text text-muted">You can upload additional images (max 2MB each).</small>
    </div>
  </div>

  <button class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
  <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
</form>

<form method="POST" action="{{ route('ads.destroy',$ad) }}" onsubmit="return confirm('Delete this ad? This cannot be undone.');">
  @csrf
  @method('DELETE')
  <button class="btn btn-danger"><i class="fas fa-trash"></i> Delete Ad</button>
</form>
@endsection
