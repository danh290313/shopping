<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Http\Response;
use Throwable;
class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    // public function render($request, Throwable $e)
    // {
    //     $statusCode = Response::HTTP_BAD_REQUEST;
    //     if ($e->getCode() >= Response::HTTP_INTERNAL_SERVER_ERROR) {
    //         $statusCode = $e->getCode();
    //     }
        
    //     $message = __('messages.errors.bad_request');
    //     $errors = null;
    //     switch (true) {
    //         case $e instanceof AuthenticationException:
    //             $message = __('messages.errors.unauthorized');
    //             $statusCode = Response::HTTP_UNAUTHORIZED;
    //             break;
               
    //         case $e instanceof NotFoundHttpException:
    //             $message = __('messages.errors.page_not_found');
    //             $statusCode = Response::HTTP_NOT_FOUND;
    //             break;

    //         case $e instanceof ModelNotFoundException:
    //             $message = __('messages.errors.model_not_found');
    //             $statusCode = Response::HTTP_NOT_FOUND;
    //             break;
            
    //         case $e instanceof ApiException:
    //             $message    = $e->getMessage();
    //             $statusCode = $e->getCode();
    //             $errors = $e->getData();
    //             break;

    //         default:
    //             break;
    //     }

    //     if ($request->is('*api*')) {
    //         return $this->makeErrorResponse($statusCode, $message, $errors);
    //     }
        
    //     return response($message, Response::HTTP_BAD_REQUEST);
    // }
    //  /**
    //  * @param int $code
    //  * @param string $message
    //  * @param array|null $errors
    //  * @param mixed|null $data
    //  * @return Response
    //  */
    // protected function makeErrorResponse(int $code, string $message, ?array $errors = null, $data = null)
    // {
    //     $response = [
    //         'status' => false,
    //         'message' => $message,
    //         'error' => $errors
    //     ];

    //     if (!empty($data)) {
    //         $response['data'] = $data;
    //     }

    //     return response()->json($response, $code);
    // }
}
