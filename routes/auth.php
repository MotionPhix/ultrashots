<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
  Route::get('register', [RegisteredUserController::class, 'create'])
    ->name('register');

  Route::post('register', [RegisteredUserController::class, 'store']);

  Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

  Route::post('login', [AuthenticatedSessionController::class, 'store']);

  Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

  Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

  Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

  Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store');
});

Route::middleware('auth')->group(function () {

  Route::get(
    'verify-email',
    EmailVerificationPromptController::class)
    ->name('verification.notice');

  Route::get(
    'verify-email/{id}/{hash}',
    VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

  Route::post(
    'email/verification-notification',
    [EmailVerificationNotificationController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('verification.send');

  Route::get(
    'confirm-password',
    [ConfirmablePasswordController::class, 'show'])
    ->name('password.confirm');

  Route::post(
    'confirm-password',
    [ConfirmablePasswordController::class, 'store']);

  Route::put(
    'password',
    [PasswordController::class, 'update'])->name('password.update');

  Route::post(
    'logout',
    [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

//    my links

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
    '/e/{contact:cid}',
    \App\Http\Controllers\Contact\Form::class
  )->name('contacts.edit');

  Route::get(
    '/s/{contact:cid}',
    \App\Http\Controllers\Contact\Show::class
  )->name('contacts.show');

  Route::patch(
    '/u/{contact:cid}',
    \App\Http\Controllers\Contact\Update::class
  )->name('contacts.update');

  Route::delete(
    '/d/{ids}',
    \App\Http\Controllers\Contact\Trash::class
  )->name('contacts.destroy');

  Route::put(
    '/r/{ids}',
    \App\Http\Controllers\Contact\Restore::class
  )->name('contacts.restore');

  Route::patch(
    '/f/{ids}',
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

  // Route::group(
  //   ['prefix' => 'tags'], function () {

  //   Route::get(
  //     '/',
  //     \App\Http\Controllers\Tag\Index::class
  //   )->name('tags.index');

  //   Route::post(
  //     '/{contact:cid}',
  //     \App\Http\Controllers\Tag\Store::class
  //   )->name('tags.store');

  //   Route::patch(
  //     '/{contact:cid}',
  //     \App\Http\Controllers\Tag\Detach::class
  //   )->name('tags.detach');

  //   Route::put(
  //     '/{contact:cid}',
  //     \App\Http\Controllers\Tag\Update::class
  //   )->name('tags.update');

  //   Route::delete(
  //     'delete/{tag:name}',
  //     \App\Http\Controllers\Tag\Trash::class
  //   )->name('tags.destroy');

  //   Route::get(
  //     '/{filter}',
  //     \App\Http\Controllers\Tag\Filtered::class
  //   )->name('tags.filter');

  // });

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

  Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

});
