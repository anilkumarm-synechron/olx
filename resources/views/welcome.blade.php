<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Welcome to OLX</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background-color: #f5f5f5; }
        h1 { font-size: 2.5em; margin-bottom: 20px; }
        a.btn { display: inline-block; margin: 10px 12px; padding: 12px 24px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 4px; font-size: 1.05em; }
        a.btn:hover { background-color: #0056b3; }
        .ads-wrapper { max-width: 1100px; margin: 50px auto 0; text-align: left; }
        .ads-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; margin-bottom:15px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 18px; }
        .card { background:#fff; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.08); padding:12px; display:flex; flex-direction:column; position:relative; transition: box-shadow .2s ease, transform .15s ease; }
        .card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.15); transform:translateY(-3px); }
        .thumb { width:100%; aspect-ratio: 4/3; background:#e3e7ec; border-radius:6px; margin-bottom:10px; display:flex; align-items:center; justify-content:center; color:#888; font-size:0.9em; font-style:italic; overflow:hidden; }
        .thumb img { width:100%; height:100%; object-fit:cover; display:block; }
        .title { font-weight:600; font-size:1.05em; margin:0 0 6px; line-height:1.25em; }
        .price { font-weight:700; color:#1d6f42; margin-bottom:6px; }
        .meta { font-size:0.75em; color:#666; display:flex; justify-content:space-between; gap:6px; flex-wrap:wrap; }
        .status { position:absolute; top:10px; left:10px; background:#17a2b8; color:#fff; font-size:0.65em; padding:4px 7px; border-radius:12px; letter-spacing:.5px; text-transform:uppercase; }
        .empty { padding:30px; background:#fff; border-radius:8px; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,0.05); }
        .actions { margin-top:25px; }
        /* Responsive tweaks */
        @media (max-width:600px){ body{ padding:25px 15px; } h1{ font-size:2em; } }
    </style>
</head>
<body>
    <h1>Welcome to OLX</h1>
    <p>Your trusted platform to buy and sell</p>
    <div class="actions">
        <a href="{{ route('login') }}" class="btn">Login</a>
        <a href="{{ route('register') }}" class="btn">Register</a>
        <a href="{{ auth()->check() ? route('ads.create') : '#' }}" class="btn" {{ auth()->check() ? '' : 'onclick="alert(\'Please login to post an ad\')"' }}>Post Your Ad</a>
    </div>

    <div class="ads-wrapper">
        <div class="ads-header">
            <h2 style="margin:0;">Latest Ads</h2>
        </div>
        @if(isset($ads) && $ads->count())
            <div class="grid">
                @foreach($ads as $ad)
                    <a href="{{ route('ads.show',$ad) }}" style="text-decoration:none;color:inherit;">
                    <div class="card" style="cursor:pointer;">
                        <span class="status">{{ ucfirst($ad->status) }}</span>
                        <div class="thumb">
                            @php $thumb = $ad->thumbnail_url; @endphp
                            @if($thumb)
                                <img src="{{ $thumb }}" alt="{{ $ad->title }}" />
                            @else
                                No Image
                            @endif
                        </div>
                        <div class="title">{{ $ad->title }}</div>
                        <div class="price">{{ $ad->price ? '$'.number_format($ad->price,2) : 'Contact' }}</div>
                        <div class="meta">
                            <span>{{ $ad->user?->name }}</span>
                            <span>{{ $ad->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty">No ads yet. @if(auth()->check())<a href="{{ route('ads.create') }}">Post the first one</a>@else Login to post one.@endif</div>
        @endif
    </div>
</body>
</html>