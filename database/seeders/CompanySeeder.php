<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Setting;
use App\Models\Subscription;
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
    $subscriptions = Subscription::all();
    $paymentPlans = Subscription::pluck('id')->all();

    \App\Models\Company::factory(3)->create()
      ->each(function ($company) use($subscriptions, $paymentPlans) {

        Setting::setSetting($company->id, 'default_sender_email', 'no-reply@company.com');
        Setting::setSetting($company->id, 'contact_group_default', 'Clients');
        Setting::setSetting($company->id, 'currency', 'USD');
        Setting::setSetting($company->id, 'url', fake()->url());

        $company->update([
          'subscription_id' => $subscriptions->random()->id,
        ]);

        // create a few contact for the $company
        Contact::factory(rand(2, 5))->create([
          'company_id' => $company->id,
        ]);

      });

  }
}
