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
    Schema::create('pengajuan_keberatan', function (Blueprint $table) {
      $table->id();

      // Relasi dengan permohonan informasi
      $table->string('nomor_registrasi'); // contoh: PPID-2025005
      $table->string('nomor_ktp');
      $table->enum('status', ['Pending', 'Selesai'])->default('Pending');
      $table->text('catatan')->nullable();
      // $table->foreignId('permohonan_informasi_id')->nullable()->constrained('permohonan_informasi')->nullOnDelete();

      // Tujuan penggunaan informasi
      $table->text('tujuan_penggunaan')->nullable();

      // Identitas Pemohon
      $table->string('nama_pemohon');
      $table->text('alamat_pemohon');
      $table->string('pekerjaan');
      $table->string('no_hp_pemohon');

      // Kasus posisi
      $table->text('kasus_posisi');

      // Identitas Kuasa Pemohon
      $table->string('nama_kuasa_pemohon')->nullable();
      $table->text('alamat_kuasa_pemohon')->nullable();
      $table->string('no_hp_kuasa_pemohon')->nullable();

      // Alasan Pengajuan Keberatan (radio button, jadi pilih 1)
      $table->string('alasan');
      $table->date('tanggal_diajukan');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pengajuan_keberatan');
  }
};
