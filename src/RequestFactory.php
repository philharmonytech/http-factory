<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory;

use Philharmony\Http\Message\Request;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

class RequestFactory implements RequestFactoryInterface
{
    public function createRequest(string $method, $uri): RequestInterface
    {
        return Request::create($method, $uri);
    }
}
