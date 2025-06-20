<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'programs';

    protected $fillable = [
        'title',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getStatusTextAttribute()
    {
        $status = status_active();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }

    public function users(): hasMany
    {
        return $this->HasMany(User::class, 'program_id');
    }
}
