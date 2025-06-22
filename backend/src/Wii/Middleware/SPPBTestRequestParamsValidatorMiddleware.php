<?php
namespace Wii\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Wii\Enum\SPPBTest;


class SPPBTestRequestParamsValidatorMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $queryParams = $request->getQueryParams();
            
            if ((!array_key_exists('test_code', $queryParams) || empty($queryParams['test_code'])) ||
              ((!array_key_exists('test_ability', $queryParams) || empty($queryParams['test_ability'])) ||
              (!array_key_exists('result') || empty($queryParams['result']))) {
              throw new \InvalidArgumentException('One or more required parameter missing');
            }

            $testCode = $queryParams['test_code'];

            if (!in_array($testCode, SPPBTest::cases(), true)) {
                throw new \InvalidArgumentException('Value of test_code parameter is invalid');
            }
            
        } catch(\Exception $e) {

            $response = new JsonResponse(['err' => $e->getMessage()], 400);
                
            return $response;
        }
        
        $response = $handler->handle($request);
        
        return $response;
    }
}