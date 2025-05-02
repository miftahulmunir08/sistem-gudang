<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'master_product_category';  // Make sure this matches your table name
    protected $primaryKey = 'uuid';
    protected $keyType = 'string'; // Pastikan tipe data sesuai
    public $incrementing = false;
    protected $guarded = [];
}
