<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimoni extends Model
{
    use  HasUuids;
    protected $fillable = [
        'no_urut',
        'nama',
        'rating',
        'konten',
        'image',
        'status',
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/testimoni') . '/' . $this->image : 'https://picsum.photos/300/300';
    }

    public function getStatusTextAttribute()
    {
        $status = status_active();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }
}
