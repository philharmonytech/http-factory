<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory;

use Philharmony\Http\Message\ServerRequest;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface
{
    /**
     * @param string $method
     * @param $uri
     * @param array<string, mixed> $serverParams
     * @return ServerRequestInterface
     */
    public function createServerRequest(
        string $method,
        $uri,
        array $serverParams = []
    ): ServerRequestInterface {
        return ServerRequest::make(
            $method,
            $uri,
            '',
            [],
            '1.1',
            $serverParams
        );
    }
}
