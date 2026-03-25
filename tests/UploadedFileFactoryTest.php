<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory\Tests;

use Philharmony\Http\Factory\UploadedFileFactory;
use Philharmony\Http\Message\Stream;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFileFactoryTest extends TestCase
{
    private string $tempFile;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tempFile = tempnam(sys_get_temp_dir(), 'Philharmony');
    }

    protected function tearDown(): void
    {
        if (isset($this->tempFile) && is_file($this->tempFile)) {
            unlink($this->tempFile);
        }

        parent::tearDown();
    }

    public function testCreateUploadedFileFromStream(): void
    {
        $stream = Stream::create('Philharmony');
        $uploadedFile = (new UploadedFileFactory())
            ->createUploadedFile($stream);

        $this->assertInstanceOf(UploadedFileInterface::class, $uploadedFile);
        $this->assertSame('Philharmony', (string)$uploadedFile->getStream());
        $this->assertSame($stream->getSize(), $uploadedFile->getSize());
    }

    public function testCreateUploadedFileWithClientMetadata(): void
    {
        $stream = Stream::create('Philharmony');

        $uploadedFile = (new UploadedFileFactory())->createUploadedFile(
            $stream,
            $stream->getSize(),
            UPLOAD_ERR_OK,
            'test.txt',
            'text/plain'
        );

        $this->assertSame('test.txt', $uploadedFile->getClientFilename());
        $this->assertSame('text/plain', $uploadedFile->getClientMediaType());
    }

    public function testCreateUploadedFileFromFile(): void
    {
        file_put_contents($this->tempFile, 'Framework');
        $uploadedFile = (new UploadedFileFactory())
            ->createUploadedFileFromFile($this->tempFile, filesize($this->tempFile));

        $this->assertInstanceOf(UploadedFileInterface::class, $uploadedFile);
        $this->assertSame('Framework', (string)$uploadedFile->getStream());
        $this->assertSame(realpath($this->tempFile), $uploadedFile->getFullPath());
    }

    public function testCreateUploadedFileFromFileWithFullPath(): void
    {
        $uploadedFile = (new UploadedFileFactory())
            ->createUploadedFileFromFile(
                $this->tempFile,
                null,
                UPLOAD_ERR_OK,
                'Philharmony',
                null,
                '/tmp/Philharmony'
            );

        $this->assertSame('Philharmony', $uploadedFile->getClientFilename());
        $this->assertNull($uploadedFile->getClientMediaType());
        $this->assertSame('/tmp/Philharmony', $uploadedFile->getFullPath());
        $this->assertSame(filesize($this->tempFile), $uploadedFile->getSize());
    }

    public function testCreateUploadedFileFromNonFileReturnsNullSize(): void
    {
        $dir = sys_get_temp_dir();

        $uploadedFile = (new UploadedFileFactory())
            ->createUploadedFileFromFile(
                $dir,
                null
            );

        $this->assertNull($uploadedFile->getSize());
    }

    public function testCreateUploadedFileFromFileThrowsOnEmptyPath(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new UploadedFileFactory())->createUploadedFileFromFile('');
    }
}
