<?php
namespace Wii\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Stream;
use Wii\Enum\Sex;
use Wii\Enum\SFTTest;


class SPPBTestSummaryRequestParamsValidatorMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        
            
        } catch(\Exception $e) {

            $response = new JsonResponse(['err' => $e->getMessage()], 400);
                
            return $response;
        }
        
        $response = $handler->handle($request);
        
        return $response;
    }
}