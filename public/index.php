<?php 
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;
use App\Controllers\UsuarioController;
use App\Controllers\MateriaController;
use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;
use \Firebase\JWT\JWT;

require __DIR__.'/../vendor/autoload.php';

$conn = new Database;

$app = AppFactory::create();
$app->setBasePath('/cuatrimestre3/Programacion3/programacion/Programacion3parcial2/public');

$app->group('/users', function(RouteCollectorProxy $group){

    $group->post('[/]', UsuarioController::class . ":addOne");

})->add(new JsonMiddleware);


$app->group('/login', function(RouteCollectorProxy $group){
    $group->post('[/]', UsuarioController::class . ":login");
});

$app->group('/materia', function(RouteCollectorProxy $group){
    $group->post('[/]', MateriaController::class . ":addOne");
})->add(new AuthMiddleware(["admin"]));

$app->group('/inscripcion', function(RouteCollectorProxy $group){
    $group->post('', MateriaController::class . ":addOne");
})->add(new AuthMiddleware(["alumno"]));

$app->addBodyParsingMiddleware();
$app->run();