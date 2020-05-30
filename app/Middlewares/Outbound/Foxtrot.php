<?php declare(strict_types = 1);


namespace app\Middlewares\Outbound;


use Psr\Http\Message\ResponseInterface;

class Foxtrot
{
    public function process(ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write("Foxtrot<br>");
        return $response;
    }
}