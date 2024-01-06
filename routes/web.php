<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::group(
  ['middleware' => 'auth'], function () {

  Route::get(
    '/groups',
    \App\Http\Controllers\Contact\Groups\Index::class
  )->name('contacts.groups.index');

  Route::get(
    '/groups/create',
    \App\Http\Controllers\Contact\Groups\Form::class
  )->name('contacts.group.create');

  Route::get(
    '/groups/{group}',
    \App\Http\Controllers\Contact\Group::class
  )->name('contacts.group.show');

  Route::post(
    '/store',
    \App\Http\Controllers\Contact\Store::class
  )->name('contacts.store');

  Route::get(
    '/create',
    \App\Http\Controllers\Contact\Form::class
  )->name('contacts.create');

  Route::get(
    '/edit/{contact:cid}',
    \App\Http\Controllers\Contact\Form::class
  )->name('contacts.edit');

  Route::get(
    '/show/{contact:cid}',
    \App\Http\Controllers\Contact\Show::class
  )->name('contacts.show');

  Route::patch(
    '/update/{contact:cid}',
    \App\Http\Controllers\Contact\Update::class
  )->name('contacts.update');

  Route::delete(
    'delete/{ids}',
    \App\Http\Controllers\Contact\Trash::class
  )->name('contacts.destroy');

  Route::put(
    'restore/{ids}',
    \App\Http\Controllers\Contact\Restore::class
  )->name('contacts.restore');

  Route::patch(
    'favourites/{ids}',
    \App\Http\Controllers\Contact\Favourite::class
  )->name('contacts.favourite');

  Route::group(
    ['prefix' => 'companies'], function () {

    Route::post(
      '/',
      \App\Http\Controllers\Company\Store::class
    )->name('companies.store');

    Route::get(
      '/{q?}',
      \App\Http\Controllers\Company\Index::class
    )->name('companies.index');

  });

  Route::group(
    ['prefix' => 'tags'], function () {

    Route::get(
      '/',
      \App\Http\Controllers\Tag\Index::class
    )->name('tags.index');

    Route::post(
      '/{contact:cid}',
      \App\Http\Controllers\Tag\Store::class
    )->name('tags.store');

    Route::patch(
      '/{contact:cid}',
      \App\Http\Controllers\Tag\Detach::class
    )->name('tags.detach');

    Route::put(
      '/{contact:cid}',
      \App\Http\Controllers\Tag\Update::class
    )->name('tags.update');

    Route::delete(
      'delete/{tag:name}',
      \App\Http\Controllers\Tag\Trash::class
    )->name('tags.destroy');

    Route::get(
      '/{filter}',
      \App\Http\Controllers\Tag\Filtered::class
    )->name('tags.filter');

  });

  Route::get(
    'search/{term?}',
    \App\Http\Controllers\Search::class
  )->name('broad.search');

  Route::get(
    '/compose',
    \App\Http\Controllers\Mails\Compose::class
  )->name('mail.compose');

  Route::post(
    '/send/{contacts}',
    \App\Http\Controllers\Mails\Send::class
  )->name('mail.send');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get(
  '/{filter?}',
  \App\Http\Controllers\Contact\Index::class
)->middleware('auth')->name('contacts.index');
