<?php

use App\Http\Middleware\ForceJson;
use App\Supports\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            ForceJson::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $apiResponse = new ApiResponse;

        $exceptions->render(fn (BadRequestHttpException $ex) => $apiResponse->error(400, $ex->getCode(), $ex->getMessage()));
        $exceptions->render(fn (AuthenticationException $ex) => $apiResponse->error(401, $ex->getCode(), $ex->getMessage()));
        $exceptions->render(fn (NotFoundHttpException $ex) => $apiResponse->error(404, $ex->getCode(), app()->environment() == 'production' ? __('message.not_found') : $ex->getMessage()));
        $exceptions->render(fn (AccessDeniedHttpException $ex) => $apiResponse->error(403, $ex->getCode(), $ex->getMessage()));
        $exceptions->render(fn (ValidationException $ex) => $apiResponse->error(422, $ex->getCode(), $ex->getMessage(), ['errors' => $ex->errors()]));
        $exceptions->render(fn (PDOException $ex) => $apiResponse->error(500, 1005, app()->environment() == 'production' ? __('message.something_wrong') : $ex->getMessage()));
        $exceptions->render(fn (QueryException $ex) => $apiResponse->error(500, 1005, app()->environment() == 'production' ? __('message.something_wrong') : $ex->getMessage()));
        $exceptions->render(fn (Exception $ex) => $apiResponse->error(500, 2001, app()->environment() == 'production' ? __('message.something_wrong') : $ex->getMessage()));
    })->create();
