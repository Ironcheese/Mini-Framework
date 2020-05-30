<?php declare(strict_types = 1);


namespace app\Middlewares\Outbound;

use Psr\Http\Message\ResponseInterface;

class Golf
{
    public function process(ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write("Golf<br>");
        return $response;
    }
}