<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    $plans = [
      [
        'name' => 'Basic',
        'price' => 0.00,
        'contact_limit' => 1000,
        'email_limit' => 10000,
        'advanced_analytics' => false,
        'custom_domain' => false,
        'subscription_type' => 'monthly',
        'duration_in_days' => 30,
      ],
      [
        'name' => 'Basic',
        'price' => 0.00,
        'contact_limit' => 1000,
        'email_limit' => 10000,
        'advanced_analytics' => false,
        'custom_domain' => false,
        'subscription_type' => 'yearly',
        'duration_in_days' => 365,
      ],
      [
        'name' => 'Pro',
        'price' => 29.99,
        'contact_limit' => 5000,
        'email_limit' => 50000,
        'advanced_analytics' => true,
        'custom_domain' => false,
        'subscription_type' => 'monthly',
        'duration_in_days' => 30,
      ],
      [
        'name' => 'Pro',
        'price' => 299.99,
        'contact_limit' => 5000,
        'email_limit' => 50000,
        'advanced_analytics' => true,
        'custom_domain' => false,
        'subscription_type' => 'yearly',
        'duration_in_days' => 365,
      ],
      [
        'name' => 'Enterprise',
        'price' => 99.99,
        'contact_limit' => null,
        'email_limit' => null,
        'advanced_analytics' => true,
        'custom_domain' => true,
        'subscription_type' => 'monthly',
        'duration_in_days' => 30,
      ],
      [
        'name' => 'Enterprise',
        'price' => 999.99,
        'contact_limit' => null,
        'email_limit' => null,
        'advanced_analytics' => true,
        'custom_domain' => true,
        'subscription_type' => 'yearly',
        'duration_in_days' => 365,
      ],
    ];

    foreach ($plans as $plan) {
      Subscription::create($plan);
    }

  }
}
