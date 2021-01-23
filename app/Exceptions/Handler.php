<?php

namespace App\Exceptions;

use App\Traits\APIResponser;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{   
    use APIResponser;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function render($request, Throwable $exception)
    {

        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe la instancia de el modelo {$model} especificado", 404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse('No posee permisos para acceder a este recurso', 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('No se ha encontrado la ruta especificada', 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('No se ha especificado el metodo', 405);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessages(), $exception->getStatusCode());
        }

         if ($exception instanceof QueryException) {
            if($exception->errorInfo[1] == 1451){
                return $this->errorResponse('No se puede eliminar el registro porque tiene relacion con otro recurso', 409);
            }
        }

        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        
        return $this->errorResponse('Falla inesperada. Intente mas tarde.', 500);

        
    }
    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
        
    }

     /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('No autorizado', 401);
    }


}