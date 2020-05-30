<?php declare(strict_types = 1);


use App\Controllers\CampaignController;
use App\Factory;
use App\Http\Router;
use App\Middlewares\Inbound\Alpha;
use App\Middlewares\Inbound\Bravo;
use App\Middlewares\Inbound\Charlie;
use App\Middlewares\Outbound\Delta;
use App\Middlewares\Outbound\Foxtrot;
use App\Middlewares\Outbound\Golf;
use App\Middlewares\Stack;

$request = Factory::createRequest();

// Simple Routes... just to the test
$router = new Router([
    '/' => [CampaignController::class, 'show'],
    // .... route definitions ...
]);

// Match the incoming request to a handler
$handler = $router->match($request);

// Inbound Middlewares, these are PSR-15 conform
$inbound_middlewares = [
    new Alpha,
    new Bravo,
    new Charlie,
];

// Dispatch the request to a handler through the inbound middleware stack
$handler_response = Stack::pipe($request)->to($handler)->through($inbound_middlewares);

// Outbound Middlewares, these are NOT PSR-15 conform...
$outbound_middlewares = [
    new Delta,
    new Foxtrot,
    new Golf,
];
// Pipe the Handler Response through the outbound middleware Stack
$server_response = Stack::pipe($handler_response)->through($outbound_middlewares);

// Emit the generated response back to the client
$emitter = Factory::createResponseEmitter();
$emitter->emit($server_response);