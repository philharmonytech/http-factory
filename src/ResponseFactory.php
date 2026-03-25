<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory;

use Philharmony\Http\Message\Response;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return Response::create(
            $code,
            [],
            '',
            '1.1',
            $reasonPhrase
        );
    }
}
