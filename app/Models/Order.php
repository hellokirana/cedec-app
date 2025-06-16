<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravolt\Indonesia\Models\Province as IndonesiaProvince;
use Laravolt\Indonesia\Models\City as IndonesiaCity;
use Laravolt\Indonesia\Models\District as IndonesiaDistrict;
use Laravolt\Indonesia\Models\Village as IndonesiaVillage;

class Order extends Model
{
    //
    use HasUuids;
    protected $fillable = [
        'layanan_id',
        'customer_id',
        'worker_id',
        'bank_id',
        'harga_member',
        'harga_worker',
        'nominal',
        'waktu',
        'alamat',
        'tanggal',
        'dari_bank',
        'nominal_transfer',
        'bukti_transfer',
        'village_code',
        'district_code',
        'city_code',
        'province_code',
        'status_pembayaran',
        'status_order',
        'worker_description',
    ];

    public function bank(): BelongsTo
    {
        return $this->BelongsTo(Bank::class, 'bank_id');
    }

    public function layanan(): BelongsTo
    {
        return $this->BelongsTo(Layanan::class, 'layanan_id');
    }

    public function customer(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'customer_id');
    }

    public function worker(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'worker_id');
    }

    public function getStatusPembayaranTextAttribute()
    {
        $status_pembayaran = list_status_pembayaran();
        return isset($status_pembayaran[$this->status_pembayaran]) ? $status_pembayaran[$this->status_pembayaran] : '';
    }

    public function getStatusOrderTextAttribute()
    {
        $status_order = list_status_order();
        return isset($status_order[$this->status_order]) ? $status_order[$this->status_order] : '';
    }

    protected $appends = ['bukti_transfer_url'];

    public function getBuktiTransferUrlAttribute()
    {
        return $this->bukti_transfer ? asset('storage/bukti_bayar') . '/' . $this->bukti_transfer : '';
    }
    public function workerProofs()
    {
        return $this->hasMany(WorkerProof::class);
    }

    public function province()
    {
        return $this->belongsTo(IndonesiaProvince::class, 'province_code', 'code');
    }

    public function city()
    {
        return $this->belongsTo(IndonesiaCity::class, 'city_code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(IndonesiaDistrict::class, 'district_code', 'code');
    }

    public function village()
    {
        return $this->belongsTo(IndonesiaVillage::class, 'village_code', 'code');
    }
    public function getRtRwAttribute()
    {
        return 'RT ' . $this->rt . ' / RW ' . $this->rw;
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

}
