<?php declare(strict_types = 1);


namespace App\Http;


use Psr\Http\Message\RequestInterface;

class Router
{
    protected array $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function match(RequestInterface $request)
    {
        return $this->routes[$request->getUri()->getPath()];
    }
}