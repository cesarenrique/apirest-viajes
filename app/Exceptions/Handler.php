<?php

namespace App\Exceptions;
use App\Http\Traits\ApiResponse;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\QueryException;


class Handler extends ExceptionHandler
{
    use ApiResponse;
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
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
           $this->convertValidationExceptionToResponse($exception,$request);
        }

        if ($exception instanceof ModelNotFoundException) {
          //return response()->json(['message' => 'Not Found!'], 404);
          return $this->errorResponse('No existe modelo con id especificado',404);
        }
        if($exception instanceof AuthenticationException){
          return $this->unauthenticated($request,$exception);
        }
        if($exception instanceof AuthorizationException){
          return $this->errorResponse('No posee permisos para ejecutar esta acción',403);
        }
        if($exception instanceof NotFoundHttpException){
          return $this->errorResponse('No se encontro la url especificada',404);
        }

        if($exception instanceof MethodNotAllowedHttpException){
          return $this->errorResponse('El método especificado en la petición no es válido',405);
        }
        if($exception instanceof HttpException){
          return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());

        }

        if($exception instanceof QueryException){
          $codigo=$exception->errorInfo[1];
          if($codigo==1451){
            return $this->errorResponse('No se puede eliminar el recurso porque esta relacionado con otro',409);
          }
          if($codigo==1062){
            return $this->errorResponse('No se puede crear el recurso porque ya hay un recurso existe parecido',409);
          }
        }
        if(config('app.debug')){
          return parent::render($request, $exception);
        }
        return $this->errorResponse('Fallo inesperado contacte con el administrador',500);
    }

    protected function unauthenticated($request, AuthenticationException $exception){

        return $this->errorResponse('unauthenticated',401);

    }

    protected function convertValidationExceptionToResponse(ValidationException $e,$request){
      $errors= $e->validator->errors()->getMessages();
      return $this->errorResponse($errors,422);
    }
}
