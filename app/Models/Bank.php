<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'no_urut',
        'nama',
        'bank',
        'no_rekening',
        'status',
    ];

    public function getStatusTextAttribute()
    {
        $status = status_active();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }
}
