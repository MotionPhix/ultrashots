<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('templates', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('company_id')->nullable();
      $table->string('name');
      $table->text('html');
      $table->text('css');
      $table->boolean('is_system')->default(false);
      $table->boolean('is_purchased')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('templates');
  }
};
