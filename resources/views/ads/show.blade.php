@php /** @var \App\Models\Ad $ad */ @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>{{ $ad->title }} - Ad Detail</title>
    <style>
        body { font-family:Arial, sans-serif; background:#f5f5f5; margin:0; padding:30px; }
        .container { max-width:1000px; margin:0 auto; background:#fff; padding:25px 30px 40px; border-radius:10px; box-shadow:0 4px 14px rgba(0,0,0,0.06); }
        h1 { margin-top:0; font-size:1.9em; }
        .meta { color:#666; font-size:0.85em; margin-top:4px; }
        .price { font-size:1.6em; font-weight:700; color:#1d6f42; margin:15px 0 10px; }
        .gallery { display:flex; flex-direction:column; gap:12px; }
        .primary { width:100%; aspect-ratio: 4/3; background:#e3e7ec; border-radius:8px; overflow:hidden; display:flex; align-items:center; justify-content:center; }
        .primary img { width:100%; height:100%; object-fit:cover; display:block; }
        .thumbs { display:flex; gap:10px; flex-wrap:wrap; }
        .thumb { width:110px; height:82px; background:#eee; border-radius:6px; overflow:hidden; cursor:pointer; border:2px solid transparent; }
        .thumb img { width:100%; height:100%; object-fit:cover; display:block; }
        .thumb.active { border-color:#007bff; }
        .desc { margin-top:25px; line-height:1.45em; white-space:pre-line; }
        a.back { display:inline-block; margin-bottom:18px; text-decoration:none; color:#007bff; }
        a.back:hover { text-decoration:underline; }
        .badge { display:inline-block; background:#17a2b8; color:#fff; padding:4px 9px; border-radius:14px; font-size:0.65em; text-transform:uppercase; letter-spacing:.5px; margin-left:8px; position:relative; top:-2px; }
        .owner { margin-top:18px; font-size:0.9em; color:#444; }
    </style>
</head>
<body>
<div class="container">
    <a href="/" class="back">← Back</a>
    <h1>{{ $ad->title }} <span class="badge">{{ ucfirst($ad->status) }}</span></h1>
    <div class="meta">Posted by {{ $ad->user?->name }} • {{ $ad->created_at->diffForHumans() }}</div>
    <div class="price">{{ $ad->price ? '$'.number_format($ad->price,2) : 'Contact for Price' }}</div>

    <div class="gallery" id="gallery">
        <div class="primary" id="primaryDisplay">
            @if($primary)
                @php $ppath = $primary->path; $purl = str_ends_with(strtolower($ppath), '.txt') ? asset('placeholder.svg') : asset('storage/'.$ppath); @endphp
                <img src="{{ $purl }}" alt="{{ $ad->title }}" id="primaryImage" />
            @else
                <span style="color:#777;font-style:italic;">No image available</span>
            @endif
        </div>
        @if($ad->photos->count() > 1)
            <div class="thumbs" id="thumbs">
                @foreach($ad->photos as $p)
                    @php $path = $p->path; $url = str_ends_with(strtolower($path), '.txt') ? asset('placeholder.svg') : asset('storage/'.$path); @endphp
                    <div class="thumb {{ $primary && $primary->id === $p->id ? 'active' : '' }}" data-src="{{ $url }}">
                        <img src="{{ $url }}" alt="thumb" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if($ad->description)
        <div class="desc">{{ $ad->description }}</div>
    @endif

    <div class="owner">
        <strong>Contact Seller</strong><br>
        <span>Name:</span> {{ $ad->user?->name }}<br>
        <span>Email:</span> <a href="mailto:{{ $ad->user?->email }}">{{ $ad->user?->email }}</a><br>
        @php $phone = $ad->user?->phone ?? null; @endphp
        <span>Phone:</span> {{ $phone ? $phone : 'Not provided' }}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const thumbs = document.querySelectorAll('.thumb');
        const primaryImg = document.getElementById('primaryImage');
        thumbs.forEach(t => t.addEventListener('click', () => {
            const src = t.getAttribute('data-src');
            if(primaryImg) primaryImg.src = src;
            thumbs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
        }));
    });
</script>
</body>
</html>
