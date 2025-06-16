<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdraw extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'worker_id',
        'nominal',
        'status',
        'bank',
        'nama',
        'no_rekening',
    ];

    public function worker(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'worker_id');
    }

    public function getStatusTextAttribute()
    {
        $status = list_status_withdraw();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }
}
