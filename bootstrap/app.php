<?php
  use Illuminate\Database\Eloquent\ModelNotFoundException;
  use Illuminate\Foundation\Application;
  use Illuminate\Foundation\Configuration\Exceptions;
  use Illuminate\Foundation\Configuration\Middleware;
  use Spatie\Permission\Exceptions\UnauthorizedException;
  use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
  use Illuminate\Http\Response;
  use Spatie\Permission\Middleware\RoleMiddleware;
  use Spatie\Permission\Middleware\PermissionMiddleware;
  use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
  use App\Traits\ApiResponse;
  
  $exceptions=[
    "type"=>ModelNotFoundException::class,
    "message"=>"Model not found",
    "status"=>Response::HTTP_NOT_FOUND,
  ];
  
  return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
      $middleware->statefulApi();
      
      $middleware->alias([
        'role' => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
        'role_or_permission' => RoleOrPermissionMiddleware::class,
      ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
      
        $exceptions->render(function (Exception $e){
          $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
          return response()->json(["status" => $statusCode,"message"=>$e->getMessage()], $statusCode);
        });
      
        $exceptions->render(function (NotFoundHttpException $e){
          return response()->json(["message" => "ID Not Found","details"=>$e->getMessage()], 404);
        });
      
      $exceptions->render(function (UnauthorizedException $e){
        return response()->json(["message" => "Unauthorized","details"=>$e->getMessage()], 401);
      });
    })->create();
