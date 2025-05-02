<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mutation extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'data_mutasi';  // Make sure this matches your table name
    protected $primaryKey = 'uuid';
    protected $keyType = 'string'; // Pastikan tipe data sesuai
    public $incrementing = false;
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }

    public function lokasi_pertama()
    {
        return $this->belongsTo(Location::class, 'lokasi_awal', 'id');
    }

    public function lokasi_kedua()
    {
        return $this->belongsTo(Location::class, 'lokasi_akhir', 'id');
    }
}
