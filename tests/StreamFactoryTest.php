<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory\Tests;

use Philharmony\Http\Factory\StreamFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

class StreamFactoryTest extends TestCase
{
    public function testCreateStreamFromStringReturnsInterface(): void
    {
        $stream = (new StreamFactory())->createStream('Philharmony');
        $this->assertInstanceOf(StreamInterface::class, $stream);
    }

    public function testCreateStreamFromFileReturnsInterface(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'Philharmony');
        $stream = (new StreamFactory())->createStreamFromFile($file);
        $this->assertInstanceOf(StreamInterface::class, $stream);
        unlink($file);
    }

    public function testCreateStreamFromResourceReturnsInterface(): void
    {
        $resource = fopen('php://output', 'w');
        $stream = (new StreamFactory())->createStreamFromResource($resource);
        $this->assertInstanceOf(StreamInterface::class, $stream);
        fclose($resource);
    }

    public function testCreateStreamFromStringHasCorrectContent(): void
    {
        $content = 'Philharmony Test Content';
        $stream = (new StreamFactory())->createStream($content);
        $this->assertSame($content, $stream->getContents());
    }

    public function testCreateStreamFromFileThrowsOnEmptyFilename(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new StreamFactory())->createStreamFromFile('');
    }

    public function testCreateStreamFromFileThrowsOnEmptyMode(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'Philharmony');
        $this->expectException(\InvalidArgumentException::class);
        (new StreamFactory())->createStreamFromFile($file, '');
        unlink($file);
    }

    public function testCreateStreamFromFileThrowsOnNonExistentFile(): void
    {
        $this->expectException(\RuntimeException::class);
        (new StreamFactory())->createStreamFromFile('/non/existent/path.txt');
    }

    public function testCreateStreamFromResourceThrowsOnInvalidResource(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new StreamFactory())->createStreamFromResource('not a resource');
    }

    public function testCreateStreamWithLargeContent(): void
    {
        $largeContent = str_repeat('A', 1024 * 1024);
        $stream = (new StreamFactory())->createStream($largeContent);
        $this->assertSame($largeContent, $stream->getContents());
        $this->assertSame(1024 * 1024, $stream->getSize());
    }
}
