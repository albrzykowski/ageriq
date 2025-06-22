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
use Wii\Middleware\SFTTestRequestParamsValidatorMiddleware;
use Wii\Middleware\SPPBTestRequestParamsValidatorMiddleware;
use Wii\Middleware\SPPBTestRequestSummaryParamsValidatorMiddleware;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;
use Wii\Dao\SFTTestDao;
use Wii\Dao\SPPBTestDao;


$container = new Container();

Dotenv::createImmutable(__DIR__.'/../')->load();


$container->add('pdo', \PDO::class)
    ->addArgument($_ENV['DB_DSN'])
    ->addArgument($_ENV['DB_USERNAME'])
    ->addArgument($_ENV['DB_PASSWORD']);
    
$container->add('sft_dao', SFTTestDao::class)
    ->addArgument($container->get('pdo'));
$container->add('sppb_test_dao', SPPBTestDao::class)
    ->addArgument($container->get('pdo'));     

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST
);

$responseFactory = new ResponseFactory();

$strategy = new JsonStrategy($responseFactory);
$router   = (new Router)->setStrategy($strategy);
$router->middleware(new AccessControlMiddleware);

/* SFT start */
$router->map('GET', '/api/tests/sft', function (ServerRequestInterface $request) use ($container): array {

    $testCode = $request->getQueryParams()['test_code'];
    $age = (int) $request->getQueryParams()['age'];
    $sex = $request->getQueryParams()['sex'];
    $result = (float) $request->getQueryParams()['result'];

    $evaluation = $container->get('sft_dao')->fetch($testCode, $age, $sex, $result);

    return $evaluation;
    
})->middleware(new SFTTestRequestParamsValidatorMiddleware);
/* SFT end */

/* SPPB start */
$router->map('GET', '/api/tests/sppb', function (ServerRequestInterface $request) use ($container): array {
    $testCode = $request->getQueryParams()['test_code'];
    $result = (float) $request->getQueryParams()['result'];

    $evaluation = $container->get('sppb_test_dao')->fetch($testCode, $result);
})->middleware(new SPPBTestRequestParamsValidatorMiddleware);
/* SPPB end */

/* SPPB summary start */
$router->map('GET', '/api/tests/sppb/summary', function (ServerRequestInterface $request) use ($container): array {
    
})->middleware(new SPPBTestSummaryRequestParamsValidatorMiddleware);
/* SPPB summary end */

$response = $router->dispatch($request);

(new SapiEmitter)->emit($response);