<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasUuids;
    protected $fillable = [
        'url',
        'nama',
        'caption',

        'favicon',
        'logo',

        'map',
        'alamat',
        'email',
        'phone',

        'facebook',
        'instagram',
        'youtube',
        'x',
    ];

    protected $appends = ['logo_url'];

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/website') . '/' . $this->logo : '';
    }
    public function url_favicon()
    {
        return $this->favicon ? asset('storage/website') . '/' . $this->favicon : '';
    }

    public function url_logo()
    {
        return $this->logo ? asset('storage/website') . '/' . $this->logo : '';
    }
}
