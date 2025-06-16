<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravolt\Indonesia\Models\Province as IndonesiaProvince;
use Laravolt\Indonesia\Models\City as IndonesiaCity;
use Laravolt\Indonesia\Models\District as IndonesiaDistrict;
use Laravolt\Indonesia\Models\Village as IndonesiaVillage;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'avatar',
        'no_telp',
        'alamat',
        'village_code',
        'district_code',
        'city_code',
        'province_code',
        'status',
        'no_rekening',
        'rt',
        'rw',
        'kategori_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    protected $appends = ['image_url'];
    public function isWorker()
    {
        return $this->hasRole('worker');
    }
    public function getImageUrlAttribute()
    {
        return $this->avatar ? asset('storage/user') . '/' . $this->avatar : 'https://via.placeholder.com/150x150.png';
    }

    public function proofs()
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

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

}
