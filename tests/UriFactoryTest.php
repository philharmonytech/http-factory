<?php

namespace Philharmony\Http\Factory\Tests;

use Philharmony\Http\Factory\UriFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class UriFactoryTest extends TestCase
{
    public function testCreateUriReturnsInterface(): void
    {
        $uri = (new UriFactory())->createUri('https://philharmony.com');
        $this->assertInstanceOf(UriInterface::class, $uri);
    }

    public function testCreateWithValidInput(): void
    {
        $uri = (new UriFactory())->createUri('https://philharmony.com');
        $this->assertEquals('https://philharmony.com', (string) $uri);
    }

    public function testCreateThrowsOnInvalidInput(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new UriFactory())->createUri('1https://phil harmony/com');
    }
}
