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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('pengirim');
            $table->string('penerima');
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->string('file_surat');
            $table->foreignId('kategori_surat_id')->constrained('kategori_surat')->onDelete('cascade');
            $table->text('isi_ringkas')->nullable();
            $table->enum('status', ['diterima', 'diproses', 'selesai'])->default('diterima');
            $table->foreignId('pembuat')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
