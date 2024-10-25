<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::factory()->create([
      'first_name' => 'Kingsley',
      'last_name' => 'Motion',
      'password' => Hash::make('run%$Ace5'),
      'email' => 'hello@ultrashots.net',
    ]);

    // Retrieve all company IDs
    $companies = Company::pluck('id')->all();

    User::factory(2)->make()->each(function ($user) use ($companies) {

      $user->company_id = collect($companies)->random();

      $user->save();

      $user->assignRole('Company Admin');

    });
  }
}
