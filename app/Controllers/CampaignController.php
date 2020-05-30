<?php


namespace app\Controllers;


use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CampaignController
{
    public function show(RequestInterface $request):ResponseInterface
    {
        // When we finally reach the controller (handler) then request went through the middlewares which modified them
        // output the header line for testing purpose
        $response = new Response;
        $response->getBody()->write(print_r($request->getHeaderLine('Middleware-Test'), true)."<hr>CampaingController::show<hr>");
        return $response;
    }
}