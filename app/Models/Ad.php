<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'price', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(AdPhoto::class);
    }

    public function primaryPhoto()
    {
        return $this->hasOne(AdPhoto::class)->where('is_primary', true);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        // Ensure we access the related model instance (->first()) not the relation builder
        $photo = $this->relationLoaded('primaryPhoto')
            ? $this->getRelation('primaryPhoto')
            : $this->primaryPhoto()->first();

        if (!$photo) {
            $fallback = $this->relationLoaded('photos') ? $this->photos->first() : $this->photos()->first();
            $photo = $fallback;
        }
        if(!$photo) {
            return asset('placeholder.svg');
        }
        $path = $photo->path;
        // If the stored path ends with .txt (fallback) use placeholder asset instead
        if(str_ends_with(strtolower($path), '.txt')) {
            return asset('placeholder.svg');
        }
        return asset('storage/' . ltrim($path, '/'));
    }
}
