<?php

declare(strict_types=1);

namespace Philharmony\Http\Factory;

use Philharmony\Http\Message\UploadedFile;
use Philharmony\Http\PsrExtension\UploadedFileFactoryFromFileInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFileFactory implements UploadedFileFactoryInterface, UploadedFileFactoryFromFileInterface
{
    public function createUploadedFile(
        StreamInterface $stream,
        ?int $size = null,
        int $error = \UPLOAD_ERR_OK,
        ?string $clientFilename = null,
        ?string $clientMediaType = null
    ): UploadedFileInterface {
        $size = $this->resolveSize($stream, $size);

        return UploadedFile::create(
            $stream,
            $size,
            $error,
            $clientFilename,
            $clientMediaType
        );
    }

    public function createUploadedFileFromFile(
        string $file,
        ?int $size = null,
        int $error = \UPLOAD_ERR_OK,
        ?string $clientFilename = null,
        ?string $clientMediaType = null,
        ?string $fullPath = null
    ): UploadedFileInterface {
        if ($file === '') {
            throw new \InvalidArgumentException('File path cannot be empty');
        }

        $size = $this->resolveSize($file, $size);

        if ($fullPath === null) {
            $fullPath = realpath($file) ?: null;
        }

        return UploadedFile::create(
            $file,
            $size,
            $error,
            $clientFilename,
            $clientMediaType,
            $fullPath
        );
    }

    private function resolveSize(StreamInterface|string $fileOrStream, ?int $size): ?int
    {
        if ($size !== null) {
            return $size;
        }

        if ($fileOrStream instanceof StreamInterface) {
            return $fileOrStream->getSize();
        }

        if (is_file($fileOrStream)) {
            $size = filesize($fileOrStream);

            return $size !== false ? $size : null;
        }

        return null;
    }
}
