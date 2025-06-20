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
        'bank_from',
        'transfer_proof',
        'payment_status',
        'status',
    ];

    public function workshop(): BelongsTo
    {
        return $this->BelongsTo(workshop::class, 'workshop_id');
    }

    public function student(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }

    public function getPaymentStatusTextAttribute()
    {
        $payment_status = payment_status();
        return isset($payment_status[$this->payment_status]) ? $payment_status[$this->payment_status] : '';
    }

    public function getRegistrationStatusTextAttribute()
    {
        $status_order = list_status_order();
        return isset($status_order[$this->status_order]) ? $status_order[$this->status_order] : '';
    }

    protected $appends = ['bukti_transfer_url'];

    public function getTransferproofUrlAttribute()
    {
        return $this->transfer_proof ? asset('storage/transfer_proof') . '/' . $this->transfer_proof : '';
    }
}
