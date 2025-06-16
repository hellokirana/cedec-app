<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Jasa extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'deskripsi', 'harga'];
}
