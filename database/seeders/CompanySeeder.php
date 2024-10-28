<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Setting;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    /*$subscriptions = Subscription::all();
    $paymentPlans = Subscription::pluck('id')->all();

    $companies = \App\Models\Company::factory(5)->create()
      ->each(function ($company) use($subscriptions, $paymentPlans) {

        Setting::setSetting($company->id, 'default_sender_email', 'no-reply@company.com');
        Setting::setSetting($company->id, 'contact_group_default', 'Clients');
        Setting::setSetting($company->id, 'currency', 'USD');

        $company->update([
          'subscription_id' => $subscriptions->random()->id,
        ]);

        // create a few contacts for the $company
        Contact::factory(rand(2, 5))->create([
          'company_id' => $company->id,
        ]);

      });

    \App\Models\Contact::all()->each(function ($contact) use($companies) {

      $contact->office_id = $companies->inRandomOrder()->first()->id;
      $contact->save();

    });*/

    $paymentPlans = Subscription::pluck('id')->all();

    DB::transaction(function () use ($paymentPlans) {

      $companies = \App\Models\Company::factory(5)->create()
        ->each(function ($company) use ($paymentPlans) {

          $company->update(['subscription_id' => $paymentPlans[array_rand($paymentPlans)]]);

          Setting::setSetting($company->id, 'default_sender_email', 'no-reply@company.com');
          Setting::setSetting($company->id, 'contact_group_default', 'Clients');
          Setting::setSetting($company->id, 'currency', 'MWK');

          Contact::factory(rand(2, 5))->create([
            'company_id' => $company->id,
          ]);

          // Add an address for each company
          \App\Models\Address::create([
            'street' => fake('ZA')->streetAddress(),
            'city' => fake('ZA')->city(),
            'state' => fake('ZA')->state(),
            'country' => fake('ZA')->country(),
            'type' => fake()->randomElement(['office', 'home']),
            'model_id' => $company->id,
            'model_type' => \App\Models\Company::class,
          ]);

        });

      Contact::all()->each(function ($contact) use ($companies) {
        $contact->update(['office_id' => $companies->random()->id]);
      });

    });
  }
}
