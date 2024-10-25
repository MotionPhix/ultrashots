<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(SubscriptionSeeder::class);
    $this->call(RolesAndPermissionsSeeder::class);
    $this->call(CompanySeeder::class);
    $this->call(UserSeeder::class);
  }
}
