<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id', 'path', 'is_primary'
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
