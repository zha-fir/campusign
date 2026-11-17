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
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket')->unique();
            $table->string('nomor_surat')->nullable();
            $table->string('nama_mahasiswa');
            $table->string('nim');
            $table->string('prodi');
            $table->string('jurusan')->default('Teknik Informatika');
            $table->string('semester')->default('6');
            $table->string('angkatan')->default('2021');
            $table->string('no_hp')->nullable();
            $table->string('jenis_surat');
            $table->text('keperluan');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['menunggu', 'dikirim_ulang', 'disetujui', 'revisi'])->default('menunggu');
            $table->text('catatan_revisi')->nullable();
            $table->foreignId('kajur_id')->nullable()->constrained('kajurs')->nullOnDelete();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};
