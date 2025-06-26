<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Workshop extends Model
{
    use HasUuids;
    protected $table = 'workshops';
    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'place',
        'fee',
        'quota',
        'status',
        'start_date',
        'end_date',
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/workshop') . '/' . $this->image : 'https://loremflickr.com/800/600';
    }

    public function getStatusTextAttribute()
    {
        $status = workshop_status();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }

    public function registrations()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

}
