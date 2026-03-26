<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory\Tests;

use Philharmony\Http\Factory\ServerRequestFactory;
use Philharmony\Http\Message\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestFactoryTest extends TestCase
{
    public function testCreateRequestFromUriString(): void
    {
        $serverRequest = (new ServerRequestFactory())
            ->createServerRequest('get', 'https://philharmony.com', ['Framework' => 'Philharmony']);

        $this->assertInstanceOf(ServerRequestInterface::class, $serverRequest);
        $this->assertSame('get', $serverRequest->getMethod());
        $this->assertSame('https://philharmony.com', (string)$serverRequest->getUri());
        $this->assertSame(['Framework' => 'Philharmony'], $serverRequest->getServerParams());
    }

    public function testCreateRequestFromUri(): void
    {
        $uri = Uri::create('https://philharmony.com:8080');
        $serverRequest = (new ServerRequestFactory())
            ->createServerRequest('POST', $uri);

        $this->assertInstanceOf(ServerRequestInterface::class, $serverRequest);
        $this->assertSame('POST', $serverRequest->getMethod());
        $this->assertSame((string)$uri, (string)$serverRequest->getUri());
        $this->assertSame($uri->getPort(), $serverRequest->getUri()->getPort());
        $this->assertSame('philharmony.com', $serverRequest->getUri()->getHost());
        $this->assertSame('https', $serverRequest->getUri()->getScheme());
        $this->assertEmpty($serverRequest->getServerParams());
        $this->assertEmpty($serverRequest->getCookieParams());
        $this->assertEmpty($serverRequest->getQueryParams());
        $this->assertNull($serverRequest->getParsedBody());
    }

    public function testCreateRequestWithServerParams(): void
    {
        $serverParams = [
            'content' => 'json',
            'string' => 'text',
            'integer' => 10,
            'boolean' => true,
        ];

        $serverRequest = (new ServerRequestFactory())
            ->createServerRequest(
                'GET',
                'http://philharmony.com',
                $serverParams
            );

        $this->assertSame($serverParams, $serverRequest->getServerParams());
    }

    public function testCreateRequestThrowsOnInvalidMethod(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new ServerRequestFactory())
            ->createServerRequest('Patch   ', 'http://philharmony.com');
    }

    public function testCreateRequestThrowsOnEmptyMethod(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new ServerRequestFactory())->createServerRequest('', 'http://philharmony.com');
    }
}
