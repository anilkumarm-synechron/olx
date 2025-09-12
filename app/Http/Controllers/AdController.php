<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ad;
use App\Models\AdPhoto;

class AdController extends Controller
{
    public function create()
    {
        return view('ads.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'active';

        $ad = Ad::create($data);

        if($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                $path = $file->store('ads','public');
                AdPhoto::create([
                    'ad_id' => $ad->id,
                    'path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Ad posted successfully');
    }

    public function show(Ad $ad)
    {
        $ad->load(['user','photos']);
        // Determine primary photo first
        $primary = $ad->photos->firstWhere('is_primary', true) ?? $ad->photos->first();
        return view('ads.show', compact('ad','primary'));
    }

    public function edit(Ad $ad)
    {
    $this->authorizeAd($ad, true); // allow admin override
        $ad->load('photos');
        return view('ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
    $this->authorizeAd($ad, true); // allow admin override
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:active,inactive',
            'photos.*' => 'nullable|image|max:2048',
            'primary_photo_id' => 'nullable|integer'
        ]);

        $ad->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'] ?? null,
            'status' => $data['status'] ?? $ad->status,
        ]);

        // Additional photos upload
        if($request->hasFile('photos')) {
            foreach($request->file('photos') as $file) {
                $path = $file->store('ads','public');
                AdPhoto::create([
                    'ad_id' => $ad->id,
                    'path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Primary photo switch
        if(!empty($data['primary_photo_id'])) {
            $ad->photos()->update(['is_primary' => false]);
            $target = $ad->photos()->where('id',$data['primary_photo_id'])->first();
            if($target) { $target->is_primary = true; $target->save(); }
        }

        // Redirect: admin back to ads list, user stays on edit page for further changes
        if(auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard',['view'=>'ads'])->with('success','Ad updated');
        }
        return redirect()->route('home')->with('success','Ad updated');
    }

    public function destroy(Ad $ad)
    {
        $this->authorizeAd($ad, true); // allow admin
        // delete files
        foreach($ad->photos as $p) {
            if($p->path && !str_ends_with(strtolower($p->path), '.txt')) {
                Storage::disk('public')->delete($p->path);
            }
            $p->delete();
        }
        $ad->delete();
        $redirect = auth()->user()->role === 'admin' ? route('admin.dashboard',['view'=>'ads']) : route('home');
        return redirect($redirect)->with('success','Ad deleted');
    }

    private function authorizeAd(Ad $ad, bool $allowAdmin = false): void
    {
        $user = auth()->user();
        if(!$user) abort(403);
        if($allowAdmin && $user->role === 'admin') return;
        if($ad->user_id !== $user->id) abort(403);
    }
}
