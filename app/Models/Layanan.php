<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Layanan extends Model 
{
    use  HasUuids;
    protected $fillable = [
        'title',
        'konten',
        'harga_member',
        'harga_worker',
        'featured',
        'status',
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/layanan') . '/' . $this->image : 'https://loremflickr.com/800/600';
    }

    public function getStatusTextAttribute()
    {
        $status = status_active();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }

    public function kategori(): belongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
