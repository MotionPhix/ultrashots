<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('company_contact', function (Blueprint $table) {
      $table->id();

      $table->string('job_title')->nullable();
      $table->string('department')->nullable();

      $table->timestamps();

      $table->unique(['contact_id', 'company_id']);

      $table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete();
      $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
    });
  }

  public function down()
  {
    Schema::dropIfExists('company_contact');
  }
};
