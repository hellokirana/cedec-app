<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Score extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'scores';
    protected $fillable = [
        'user_id',
        'registration_id',
        'score',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function registration()
    {
        return $this->belongsTo(WorkshopRegistration::class, 'registration_id');
    }
    
}
