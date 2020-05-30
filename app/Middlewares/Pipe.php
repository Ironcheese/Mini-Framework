<?php


namespace App\Middlewares;


use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Pipe implements RequestHandlerInterface
{
    protected ?RequestInterface $request = null;
    protected ?ResponseInterface $response = null;
    protected array $middlewares = [];
    protected $handler = null;

    public function __construct(?MessageInterface $message) {
        if ($message instanceof RequestInterface) {
            $this->request = $message;
        } else {
            $this->response = $message;
        }
    }

    public function to($handler):self
    {
        if (is_callable($handler)) {
            $this->handler = $handler;
        }

        if (is_array($handler)) {
            list($class, $method) = $handler;
            $this->handler = [
                new $class,
                $method
            ];
        }

        return $this;
    }

    public function through(array $middlewares): ResponseInterface
    {
        $this->middlewares = $middlewares;
        if ($this->request) {
            return $this->handle($this->request);
        }

        return $this->handleOutbound($this->response);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = array_shift($this->middlewares);
        $this->request = $request;
        if ($middleware) {
            return $middleware->process($this->request, $this);
        }
        return call_user_func($this->handler, $this->request);
    }

    public function handleOutbound(ResponseInterface $response): ResponseInterface
    {
        while($middleware = array_shift($this->middlewares)) {
            $response = $middleware->process($response);
        }
        return $response;
    }
}