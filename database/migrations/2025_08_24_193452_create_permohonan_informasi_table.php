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
    Schema::create('permohonan_informasi', function (Blueprint $table) {
      $table->id();

      $table->string('nomor_registrasi', 50);
      $table->string('nama_pemohon'); // Nama Pemohon (Pribadi/Badan Hukum)
      $table->string('nomor_ktp'); // Nomor KTP
      $table->string('foto_ktp'); // Upload Foto KTP (path file)
      $table->string('nomor_pengesahan')->nullable(); // Nomor Pengesahan (Badan Hukum)
      $table->text('alamat'); // Alamat
      $table->string('pekerjaan'); // Pekerjaan
      $table->string('no_hp'); // Nomor HP
      $table->string('email'); // Email

      $table->text('rincian_informasi'); // Rincian Informasi yang Dibutuhkan
      $table->date('tanggal_diajukan');
      $table->text('tujuan_permohonan'); // Tujuan Permohonan Informasi

      $table->string('cara_memperoleh_informasi');
      // Cara Memperoleh Informasi (contoh: melihat, membaca, mendengarkan, mencatat)

      $table->string('mendapatkan_salinan');
      // Mendapatkan Salinan Informasi (contoh: hardcopy, softcopy)

      $table->string('cara_mendapatkan_salinan');
      // Cara Mendapatkan Salinan Informasi (contoh: diambil langsung, pos, email)

      $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
      $table->text('catatan')->nullable();

      $table->string('lampiran')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('permohonan_informasi');
  }
};
