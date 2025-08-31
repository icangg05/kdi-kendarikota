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
    Schema::create('aplikasi', function (Blueprint $table) {
      $table->id();
      $table->string('nama', 125);
      $table->string('icon')->nullable();
      $table->string('link');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('aplikasi');
  }
};
