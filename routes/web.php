<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get(
  '/{filter?}',
  \App\Http\Controllers\Contact\Index::class
)->middleware('auth')->name('contacts.index');
