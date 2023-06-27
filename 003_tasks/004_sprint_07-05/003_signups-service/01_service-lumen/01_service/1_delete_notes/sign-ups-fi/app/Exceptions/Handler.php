<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Spatie\DataTransferObject\DataTransferObjectError;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        if (env('APP_DEBUG')) {
          return parent::render($request, $e);
        }

        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($e instanceof HttpResponseException) {
          $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        } elseif ($e instanceof MethodNotAllowedHttpException) {
          $status = Response::HTTP_METHOD_NOT_ALLOWED;
          $e = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $e);

        } elseif ($e instanceof NotFoundHttpException ||
          $e instanceof ModelNotFoundException) {
          $status = Response::HTTP_NOT_FOUND;
          $e = new NotFoundHttpException('HTTP_NOT_FOUND', $e);

        } elseif ($e instanceof Missing404Exception) {
          $status = Response::HTTP_NOT_FOUND;
          $e = new NotFoundHttpException('No resource found: ' . $e->getMessage(), $e);

        } elseif ($e instanceof DataTransferObjectError) {
          $status = Response::HTTP_BAD_REQUEST;
          $e = new HttpException($status, $e->getMessage());

        } elseif ($e instanceof AuthorizationException) {
          $status = Response::HTTP_FORBIDDEN;
          $e = new AuthorizationException('HTTP_FORBIDDEN', $status);

        } elseif ($e instanceof \Dotenv\Exception\ValidationException && $e->getResponse()) {
          $status = Response::HTTP_BAD_REQUEST;
          $e = new \Dotenv\Exception\ValidationException('HTTP_BAD_REQUEST', $status, $e);
          
        } elseif ($e) {
          $e = new HttpException($status, 'HTTP_INTERNAL_SERVER_ERROR');
        }

        return response()->json([
          'success' => false,
          'status' => $status,
          'message' => $e->getMessage()
        ], $status);
    }
}
