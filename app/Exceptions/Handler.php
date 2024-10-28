<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
  /**
   * The list of the inputs that are never flashed to the session on validation exceptions.
   *
   * @var array<int, string>
   */
  protected $dontFlash = [
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
   * Register the exception handling callbacks for the application.
   */
  public function register(): void
  {
    $this->reportable(function (Throwable $e) {
      //
    });
  }

  public function render($request, Throwable $e)
  {
    /*if ($this->isHttpException($e)) {
      return match ($e->getStatusCode()) {
        500, 404 => redirect()->guest('/'),
        default => $this->renderHttpException($e),
      };
    } else {
      return parent::render($request, $e);
    }*/

    if ($e instanceof NotFoundHttpException) {
      return Inertia::render('NotFound', [
        'status' => 404,
        'message' => $request->url() . ' couldn\'t be found. Did you type the correct url?',
      ])->toResponse($request)->setStatusCode(404);
    }

    return parent::render($request, $e);

  }
}
