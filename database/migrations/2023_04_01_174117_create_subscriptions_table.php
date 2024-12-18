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
    Schema::create('subscriptions', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->decimal('price', 8, 2);
      $table->integer('contact_limit')->nullable();
      $table->integer('email_limit')->nullable();
      $table->integer('duration_in_days')->default(30);
      $table->string('subscription_type')->default('monthly');
      $table->boolean('advanced_analytics')->default(false);
      $table->boolean('custom_domain')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('subscriptions');
  }
};
