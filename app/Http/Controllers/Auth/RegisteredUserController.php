<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return Inertia::render('Auth/Register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request)
  {
    $request->validate([
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['required', 'string', 'max:255'],
      'company_name' => ['required'],
      'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:' . User::class],
      'password' => ['required', Rules\Password::defaults()],
    ], [
      'first_name.required' => 'You didn\'t enter your first name',
      'last_name.required' => 'You didn\'t enter your last name',
      'email.required' => 'Your email address is blank',
      'email.email' => 'Provide a valid email address',
      'email.unique' => 'Email address is already used. Try to login instead',
      'company_name.required' => 'Please enter the company you represent',
      'password.required' => 'You can\'t leave the password blank'
    ]);

    $company = Company::create(['name' => $request->company_name]);

    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'company_id' => $company->id,
    ]);

    // Assign role to first user of the above company as Company Admin
    $user->assignRole('Company Admin');

    // Assign a default subscription
    $basicMonthlySubscription = \App\Models\Subscription::where('name', 'Basic')
      ->where('subscription_type', 'monthly')
      ->first();

    $company->subscription()->associate($basicMonthlySubscription);
    $company->save();

    event(new Registered($user));

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
  }
}
