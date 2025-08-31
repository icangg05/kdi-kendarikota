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
    Schema::create('pejabat', function (Blueprint $table) {
      $table->id();
      $table->foreignId('opd_id')->constrained('opd')->onDelete('cascade');
      $table->string('nama', 100);
      $table->foreignId('jabatan_id')->constrained('jabatan')->onDelete('cascade');
      $table->text('keterangan')->nullable();
      $table->string('foto')->nullable();
      $table->string('facebook')->nullable();
      $table->string('twitter')->nullable();
      $table->string('instagram')->nullable();
      $table->string('tahun_periode')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pejabat');
  }
};
