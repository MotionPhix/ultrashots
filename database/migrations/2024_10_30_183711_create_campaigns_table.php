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
    Schema::create('campaigns', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('subject');
      $table->text('template_content');
      $table->string('time_period');
      $table->timestamp('start_at')->nullable();
      $table->timestamp('end_at')->nullable();
      $table->timestamp('campaign_start_time')->nullable();

      $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
      $table->foreignId('template_id')->constrained('templates')->nullOnDelete();

      $table->unsignedBigInteger('status_id');
      $table->unsignedBigInteger('created_by')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('campaigns');
  }
};
