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
    Schema::create('dokumen_ppid', function (Blueprint $table) {
      $table->id();

      $table->foreignId('users_id')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

      $table->string('kategori');
      $table->string('judul');
      $table->string('slug')->unique();
      $table->date('tanggal_publish');
      $table->string('lampiran')->nullable();
      $table->integer('total_unduh')->default(0);
      $table->integer('total_lihat')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('dokumen_ppid');
  }
};
