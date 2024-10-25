<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('contacts', function (Blueprint $table) {
      $table->id();
      $table->string('first_name', 50);
      $table->string('last_name', 50)->nullable();
      $table->string('title', 10)->nullable();
      $table->string('middle_name', 50)->nullable();
      $table->text('bio')->nullable();

      $table->foreignId('company_id')->index()->constrained('companies')->cascadeOnDelete();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('contacts');
  }
};
