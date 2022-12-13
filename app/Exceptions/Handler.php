<?php

namespace App\Exceptions;

use Request;
use Response;
use Throwable;
use responseJson;

use Illuminate\Support\Arr;
use App\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */


    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
        ? $this->responseJson(0, 'unauthenticated.')
        : redirect()->guest($exception->redirectTo() ?? route('login'));

    }
}
