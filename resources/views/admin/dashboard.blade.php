@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')

@section('content')
  @if(request('view')=='users' && isset($users))
    <h3>All Users</h3>
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ ucfirst($user->role) }}</td>
          <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @elseif(request('view')=='ads' && isset($ads))
    <h3>All Ads</h3>
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Thumb</th>
          <th>Title</th>
          <th>Price</th>
          <th>User</th>
          <th>Status</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ads as $ad)
        <tr>
          <td>{{ $ad->id }}</td>
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
          <td>{{ $ad->user?->name }}</td>
          <td>{{ ucfirst($ad->status) }}</td>
          <td>{{ $ad->created_at->format('Y-m-d H:i') }}</td>
          <td style="width:140px;">
            <a href="{{ route('ads.edit',$ad) }}" class="btn btn-sm btn-warning mb-1"><i class="fas fa-edit"></i></a>
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
    {{ $ads->links() }}
  @else
    <p>Welcome to the Admin Panel. Use the sidebar to navigate.</p>
  @endif
@endsection