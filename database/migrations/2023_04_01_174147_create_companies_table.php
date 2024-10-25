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
    Schema::create('companies', function (Blueprint $table) {
      $table->id();

      $table->uuid('fid')->nullable();

      $table->string('name', 50)->unique();
      $table->string('slogan', 255)->nullable();
      $table->string('url')->nullable();
      $table->string('slug');
      $table->boolean('banned')->default(false);

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
    Schema::dropIfExists('companies');
  }
};
