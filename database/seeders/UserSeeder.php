<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    /*Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('users');

    Schema::create('users', function ($table) {
      $table->id();
      $table->string('name');
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->timestamps();
    });

    Schema::enableForeignKeyConstraints();*/

    $users = \App\Models\User::factory(1)->create();
    $roles = \App\Models\Role::pluck('id')->toArray();

    foreach ($users as $user) {
      // $user->syncRoles([$roles->random(rand(3, 5))]);
      $user->roles()->attach(Arr::random($roles, rand(3, 5)));
    }
  }
}
