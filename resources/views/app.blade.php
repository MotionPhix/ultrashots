<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title inertia>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=dm-serif-display:400" rel="stylesheet" />
  <link href="https://fonts.bunny.net/css?family=roboto:300,400,500,700" rel="stylesheet" />

  <!-- Scripts -->
  @routes
  @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
  @inertiaHead
</head>

<body class="font-sans antialiased bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark">
  @inertia

  {{-- <x-responsive-helper /> --}}
</body>
</html>
