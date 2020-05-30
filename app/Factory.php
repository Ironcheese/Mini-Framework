<?php declare(strict_types = 1);


namespace App;


use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

class Factory
{
    public static function createRequest():ServerRequestInterface
    {
        return (new ServerRequestCreator(
            new Psr17Factory(), // ServerRequestFactory
            new Psr17Factory(), // UriFactory
            new Psr17Factory(), // UploadedFileFactory
            new Psr17Factory()  // StreamFactory
        ))->fromGlobals();
    }

    public static function createResponseEmitter(): SapiEmitter
    {
        return new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
    }
}