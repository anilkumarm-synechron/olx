@extends('layouts.user')

@section('title', 'Dashboard')

@section('page-title', 'User Dashboard')

@section('content')
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="mb-3">
  <a href="{{ route('ads.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Post New Ad</a>
</div>
<div class="card">
  <div class="card-header bg-primary text-white">
    <h3>Latest Ads</h3>
  </div>
  <div class="card-body p-0">
    @if(isset($ads) && $ads->count())
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>Photo</th>
            <th>Title</th>
            <th>Price</th>
            <th>Posted By</th>
            <th>Posted At</th>
            <th>Status</th>
            <th style="width:130px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($ads as $ad)
            <tr>
              <td style="width:70px;">
                @php $thumb = $ad->thumbnail_url; @endphp
                @if($thumb)
                  <img src="{{ $thumb }}" alt="thumb" style="width:60px;height:45px;object-fit:cover;border-radius:4px;" />
                @else
                  <div style="width:60px;height:45px;background:#e0e0e0;border-radius:4px;font-size:10px;display:flex;align-items:center;justify-content:center;color:#666;">No Img</div>
                @endif
              </td>
              <td>{{ $ad->title }}</td>
              <td>{{ $ad->price ? '$'.number_format($ad->price,2) : '—' }}</td>
              <td>{{ $ad->user->name }}</td>
              <td>{{ $ad->created_at->diffForHumans() }}</td>
              <td><span class="badge badge-info">{{ ucfirst($ad->status) }}</span></td>
              <td>
                <a href="{{ route('ads.edit',$ad) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                <form action="{{ route('ads.destroy',$ad) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this ad?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p class="p-3 mb-0">No ads yet. Be the first to <a href="{{ route('ads.create') }}">post one</a>.</p>
    @endif
  </div>
</div>
@endsection