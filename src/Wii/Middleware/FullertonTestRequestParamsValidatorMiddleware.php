<?php
namespace Wii\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Stream;
use Wii\Enum\Sex;
use Wii\Enum\FullertonTest;


class FullertonTestRequestParamsValidatorMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $queryParams = $request->getQueryParams();
            
            if ((!array_key_exists('test_code', $queryParams) || empty($queryParams['test_code'])) || 
                (!array_key_exists('sex', $queryParams) || empty($queryParams['sex'])) ||
                (!array_key_exists('age', $queryParams) || empty($queryParams['age'])) ||
                (!array_key_exists('result', $queryParams) || empty($queryParams['result']))) {
                    throw new \InvalidArgumentException('One or more required parameter missing');
            }
            
            $testCode = $queryParams['test_code'];
            $sex = $queryParams['sex'];
            $age = (int) $queryParams['age'];
            $result = (float) $queryParams['result'];
            
            if (!in_array($testCode, array_column(FullertonTest::cases(), 'value'), true)) {
                throw new \InvalidArgumentException('Value of test_code parameter is invalid');
            }
            if (!in_array($sex, array_column(Sex::cases(), 'value'), true)) {
                throw new \InvalidArgumentException('Value of sex parameter is invalid');
            }
            if ($age < 60) {
                throw new \InvalidArgumentException('The patient\'s age cannot be less than 60 years');
            }
            if ($age > 94) {
                throw new \InvalidArgumentException('The test is intended for people under 94 years of age');
            }
            
        } catch(\Exception $e) {

            $response = new JsonResponse(['err' => $e->getMessage()], 400);
                
            return $response;
        }
        
        $response = $handler->handle($request);
        
        return $response;
    }
}