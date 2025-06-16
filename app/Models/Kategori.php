<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Kategori extends Model
{
    use HasUuids;
    protected $table = 'kategoris';

    protected $fillable = [
        'no_urut',
        'image',
        'title',
        'status',
        'created_at',
        'updated_at',
    ];


    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/kategori') . '/' . $this->image : 'https://picsum.photos/200/300';
    }

    public function getStatusTextAttribute()
    {
        $status = status_active();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }

    public function layanans(): HasMany
    {
        return $this->HasMany(Layanan::class, 'kategori_id');
    }
}
