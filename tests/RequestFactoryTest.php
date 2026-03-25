<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory\Tests;

use Philharmony\Http\Factory\RequestFactory;
use Philharmony\Http\Message\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class RequestFactoryTest extends TestCase
{
    public function testCreateRequestFromUriString(): void
    {
        $request = (new RequestFactory())
            ->createRequest('get', 'http://philharmony.com');

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertSame('get', $request->getMethod());
        $this->assertSame('http://philharmony.com', (string)$request->getUri());
    }

    public function testCreateRequestFromUri(): void
    {
        $uri = Uri::create('http://philharmony.com:8080');
        $request = (new RequestFactory())
            ->createRequest('POST', $uri);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame((string)$uri, (string)$request->getUri());
        $this->assertSame($uri->getPort(), $request->getUri()->getPort());
        $this->assertSame('philharmony.com', $request->getUri()->getHost());
        $this->assertSame('http', $request->getUri()->getScheme());
    }

    public function testCreateRequestWithEmptyUri(): void
    {
        $request = (new RequestFactory())->createRequest('GET', '');

        $this->assertSame('', (string)$request->getUri());
    }

    public function testCreateRequestThrowsOnInvalidMethod(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new RequestFactory())
            ->createRequest('Patch   ', 'http://philharmony.com');
    }

    public function testCreateRequestThrowsOnEmptyMethod(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new RequestFactory())->createRequest('', 'http://philharmony.com');
    }
}
