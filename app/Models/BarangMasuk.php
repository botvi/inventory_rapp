<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory; 
    protected $fillable = [
        'user_id',
        'supplier_id',
        'barang_id',
        'tanggal_masuk',
        'jumlah'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
