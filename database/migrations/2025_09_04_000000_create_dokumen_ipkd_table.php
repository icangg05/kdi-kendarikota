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
    Schema::create('dokumen_ipkd', function (Blueprint $table) {
      $table->id();
      $table->string('judul');
      $table->string('tahun_pelaporan', 4)->index();
      $table->date('tgl_publish')->nullable();
      $table->date('tgl_disahkan')->nullable();
      $table->string('lampiran')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('dokumen_ipkd');
  }
};
