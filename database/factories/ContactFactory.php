<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class ContactFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'first_name' => fake('en_ZA')->firstName(),
      'last_name' => fake('en_ZA')->lastName(),
      'company_id' => \App\Models\Company::inRandomOrder()->first()->id
    ];
  }

  public function configure()
  {
    return $this->afterCreating(function (\App\Models\Contact $contact) {

      // Create random phone numbers for the contact
      $numPhoneNumbers = fake()->randomElement([1, 3]);

      for ($i = 0; $i < $numPhoneNumbers; $i++) {
        $contact->phones()->create([
          'number' => fake('en_ZA')->phoneNumber(),
          'type' => fake('en_ZA')->randomElement(['work', 'mobile', 'home']),
        ]);
      }

      // Create random emails for the contact
      $numEmailAddress = fake()->randomElement([1, 2]);

      for ($i = 0; $i < $numEmailAddress; $i++) {
        $contact->emails()->create([
          'email' => fake('en_ZA')->unique()->companyEmail(),
        ]);
      }

    });
  }
}
