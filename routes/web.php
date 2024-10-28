<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
  return \Inertia\Inertia::render('Index', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
  ]);
})->name('home');

Route::get('/contact-us', function() {
  return \Inertia\Inertia::render('ContactUs');
})->name('contact.us');

Route::get('/templates', function() {
  return \Inertia\Inertia::render('Templates/Index');
})->name('templates.starter');

//Route::get(
//  '/{filter?}',
//  \App\Http\Controllers\Contact\Index::class
//)->middleware('auth')->name('contacts.index');

require __DIR__ . '/auth.php';
