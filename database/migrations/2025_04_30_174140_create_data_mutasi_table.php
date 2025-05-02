<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_mutasi', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('product_id')->constrained('master_product');
            $table->foreignId('pegawai_id')->constrained('master_pegawai');
            $table->enum('jenis', ['masuk', 'keluar', 'pindah']);
            $table->integer('jumlah');
            $table->foreignId('lokasi_awal')->nullable()->constrained('master_lokasi');
            $table->foreignId('lokasi_akhir')->nullable()->constrained('master_lokasi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mutasi');
    }
};
