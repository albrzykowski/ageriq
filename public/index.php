<?php declare(strict_types=1);

include __DIR__.'/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\ResponseFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Strategy\JsonStrategy;
use League\Route\Router;
use Dotenv\Dotenv;

$container = new League\Container\Container();

Dotenv::createImmutable(__DIR__.'/../')->load();

$container->add('pdo', \PDO::class)
    ->addArgument($_ENV['DB_DSN'])
    ->addArgument($_ENV['DB_USERNAME'])
    ->addArgument($_ENV['DB_PASSWORD']);


$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST
);

$responseFactory = new ResponseFactory();

$strategy = new JsonStrategy($responseFactory);
$router   = (new Router)->setStrategy($strategy);

$router->map('GET', '/tests/fullerton', function (ServerRequestInterface $request) use ($container): array {

    // $testCode = $request->getQueryParams()['test_code'];
    $age = (float) $request->getQueryParams()['age'];
    $sex = $request->getQueryParams()['sex'];
    $result = (float) $request->getQueryParams()['result'];
    
    return [
        'sex'   => $sex,
        'age' => $age,
    ];
});

$response = $router->dispatch($request);

(new SapiEmitter)->emit($response);