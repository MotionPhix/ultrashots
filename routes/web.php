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

Route::get('/builderjs/dist/templates/default', function () {
  return response()->file(public_path('builderjs/dist/templates/default/index.html'));
});

Route::group(['starters'], function () {

  Route::post(
    '/',
    \App\Http\Controllers\Company\Store::class
  )->name('brands.store');

})->middleware('auth');


//Route::get(
//  '/{filter?}',
//  \App\Http\Controllers\Contact\Index::class
//)->middleware('auth')->name('contacts.index');

require __DIR__ . '/auth.php';
