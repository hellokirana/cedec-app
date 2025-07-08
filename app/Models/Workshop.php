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
        'registration_start_date',
        'registration_end_date',
        'workshop_start_date',
        'workshop_end_date',
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/workshop') . '/' . $this->image : asset('assets/images/default-workshop.png');
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
