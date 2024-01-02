<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Inertia\ResponseFactory;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // ResponseFactory::macro('modal', function ($modal) {
    //   inertia()->share(['modal' => $modal]);
    // });
  }
}
