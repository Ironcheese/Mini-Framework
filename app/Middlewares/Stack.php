<?php


namespace App\Middlewares;


use Psr\Http\Message\MessageInterface;

class Stack
{
    public static function pipe(MessageInterface $message)
    {
        return new \App\Middlewares\Pipe($message);
    }
}