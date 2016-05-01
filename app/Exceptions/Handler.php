<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use PDOException;

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
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        //only return prettified errors if we're not in debug mode
        if ( !getenv('APP_DEBUG') ) {
            
            //provide more helpful errors for most likely exception types
            if ( $e instanceof PDOException ) {
                return response()->json(['error' => 500, 'message' => "Database unavailable."], 500);
            } elseif ( $e instanceof NotFoundHttpException ) {
                return response()->json(['error' => $e->getStatusCode(), 'message' => $e->getMessage()?: "API path does not exist."], 404);
            } elseif ( $e instanceof MissingParameterException ){
                return response()->json(['error' => 400, 'message' => $e->getMessage()?:"Invalid parameter provided."], 400);
            } elseif ( $e instanceof Exception ) {
                return response()->json(['error' => 400, 'message' => "Misc error occurred."], 400);
            }
        }
        
        return parent::render($request, $e);
    }
}
