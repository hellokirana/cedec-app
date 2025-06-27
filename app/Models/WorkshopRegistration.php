<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopRegistration extends Model
{
    use HasUuids;
    protected $table = 'workshop_registrations';
    protected $fillable = [
        'user_id',
        'workshop_id',
        'time',
        'date',
        'transfer_proof',
        'payment_status',
        'status',
    ];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(workshop::class, 'workshop_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function score()
    {
        return $this->hasMany(Score::class, 'registration_id');
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'registration_id');
    }


    public function getPaymentStatusTextAttribute()
    {
        $payment_status = payment_status();
        return isset($payment_status[$this->payment_status]) ? $payment_status[$this->payment_status] : '';
    }

    public function getRegistrationStatusTextAttribute()
    {
        $registration_status = registration_status();
        return isset($registration_status[$this->status]) ? $registration_status[$this->status] : '';
    }


    protected $appends = ['transfer_proof_url', 'average_score'];

    public function getTransferproofUrlAttribute()
    {
        return $this->transfer_proof ? asset('storage/transfer_proof') . '/' . $this->transfer_proof : '';
    }

    public function getAverageScoreAttribute()
    {
        if (!$this->scores) {
            return 0;
        }

        return $this->scores->count() > 0
            ? round($this->scores->avg('score'), 2)
            : 0;
    }


}
