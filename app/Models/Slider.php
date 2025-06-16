<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'no_urut',
        'title',
        'image',
        'status',
    ];


    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/slider') . '/' . $this->image : 'https://loremflickr.com/1280/720?random='.$this->no_urut;
    }

    public function getStatusTextAttribute()
    {
        $status = status_active();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }

}
