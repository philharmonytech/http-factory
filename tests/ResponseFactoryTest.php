<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory\Tests;

use Philharmony\Http\Factory\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ResponseFactoryTest extends TestCase
{
    public function testCreateResponse(): void
    {
        $response = (new ResponseFactory())->createResponse(200, 'OK');
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('', (string)$response->getBody());
        $this->assertSame('1.1', $response->getProtocolVersion());
    }

    public function testCreateResponseOnEmptyReasonPhrase(): void
    {
        $response = (new ResponseFactory())->createResponse(301);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(301, $response->getStatusCode());
        $this->assertSame('Moved Permanently', $response->getReasonPhrase());
    }

    public function testCreateResponseThrowsOnInvalidStatusCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new ResponseFactory())->createResponse(601, 'Invalid status code');
    }
}
