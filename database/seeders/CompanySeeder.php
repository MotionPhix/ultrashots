<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $companies = \App\Models\Company::factory(3)->create();

    $companies->each(function ($company) {

      Setting::setSetting($company->id, 'payment_plan', fake()->randomElement(['Silver', 'Platinum', 'Gold']));
      Setting::setSetting($company->id, 'url', fake()->url());

    });

  }
}
