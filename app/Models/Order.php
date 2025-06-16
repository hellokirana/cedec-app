<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mitra_id',
        'status',
        'alamat',
        'kode_pos',
        'kelurahan',
        'kecamatan',
        'total_harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function hasWarranty()
    {
        return $this->orderDetails()->whereHas('layanan', function ($query) {
            $query->where('garansi', true);
        })->exists();
    }

}
