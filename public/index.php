<?php declare(strict_types=1);

include __DIR__.'/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\ResponseFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Strategy\JsonStrategy;
use League\Route\Router;
use Dotenv\Dotenv;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Wii\Middleware\AccessControlMiddleware;
use Wii\Middleware\FullertonTestRequestParamsValidatorMiddleware;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;
use Wii\Dao\FullertonTestDao;


$container = new Container();

Dotenv::createImmutable(__DIR__.'/../')->load();


$container->add('pdo', \PDO::class)
    ->addArgument($_ENV['DB_DSN'])
    ->addArgument($_ENV['DB_USERNAME'])
    ->addArgument($_ENV['DB_PASSWORD']);
    
$container->add('ft_dao', FullertonTestDao::class)
    ->addArgument($container->get('pdo'));    

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST
);

$responseFactory = new ResponseFactory();

$strategy = new JsonStrategy($responseFactory);
$router   = (new Router)->setStrategy($strategy);
$router->middleware(new AccessControlMiddleware);


$router->map('GET', '/api/tests/fullerton', function (ServerRequestInterface $request) use ($container): array {

    $testCode = $request->getQueryParams()['test_code'];
    $age = (int) $request->getQueryParams()['age'];
    $sex = $request->getQueryParams()['sex'];
    $result = (float) $request->getQueryParams()['result'];

    $evaluation = $container->get('ft_dao')->fetch($testCode, $age, $sex, $result);

    return $evaluation;
    
})->middleware(new FullertonTestRequestParamsValidatorMiddleware);

$response = $router->dispatch($request);

(new SapiEmitter)->emit($response);