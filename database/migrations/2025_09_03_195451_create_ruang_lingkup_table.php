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
    Schema::create('ruang_lingkup', function (Blueprint $table) {
      $table->id();
      $table->string('judul');
      $table->string('slug')->unique();
      $table->string('sampul')->nullable();
      $table->date('tanggal_publish');
      $table->text('konten');
      $table->string('lampiran')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ruang_lingkup');
  }
};
