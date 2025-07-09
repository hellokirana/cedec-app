<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WorkshopRegistration extends Model
{
    use HasUuids;

    protected $table = 'workshop_registrations';

    protected $fillable = [
        'user_id',
        'workshop_id',
        'time',
        'transfer_proof',
        'payment_status',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan Workshop
    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Accessor untuk payment status badge
    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'paid' => 'success',
            'unpaid' => 'danger'
        ];

        return $badges[$this->payment_status] ?? 'secondary';
    }

    // Accessor untuk status text
    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected'
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    // Accessor untuk payment status text
    public function getPaymentStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'unpaid' => 'Unpaid'
        ];

        return $statuses[$this->payment_status] ?? 'Unknown';
    }

    // Accessor untuk transfer proof URL
    public function getTransferProofUrlAttribute()
    {
        return $this->transfer_proof ? asset('storage/transfer_proof/' . $this->transfer_proof) : null;
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan payment status
    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    // Scope untuk filter berdasarkan workshop
    public function scopeByWorkshop($query, $workshopId)
    {
        return $query->where('workshop_id', $workshopId);
    }
}