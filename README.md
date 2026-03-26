# http-factory

[![Validate](https://github.com/philharmonytech/http-factory/actions/workflows/ci.yaml/badge.svg?job=validate)](https://github.com/philharmonytech/http-factory/actions/workflows/ci.yml)
[![Analysis](https://github.com/philharmonytech/http-factory/actions/workflows/ci.yaml/badge.svg?job=static-analysis)](https://github.com/philharmonytech/http-factory/actions/workflows/ci.yml)
[![Test](https://github.com/philharmonytech/http-factory/actions/workflows/ci.yaml/badge.svg?job=tests)](https://github.com/philharmonytech/http-factory/actions/workflows/ci.yml)
[![codecov](https://codecov.io/github/philharmonytech/http-factory/graph/badge.svg?token=JVGM1RRACK)](https://codecov.io/github/philharmonytech/http-factory)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20to%208.4-8892BF.svg)](https://www.php.net/supported-versions.php)
[![Latest Stable Version](https://img.shields.io/github/v/release/philharmonytech/http-factory?label=stable)](https://github.com/philharmonytech/http-factory/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/philharmony/http-factory)](https://packagist.org/packages/philharmony/http-factory)
[![License](https://img.shields.io/packagist/l/philharmony/http-factory)](https://github.com/philharmonytech/http-factory/blob/main/LICENSE)

PSR-17 HTTP factory implementation for the Philharmony framework.

## Installation

```bash
composer require philharmony/http-factory
```

## 🚀 Usage

### Create a Server Request

```php
use Philharmony\Http\Factory\ServerRequestFactory;

$factory = new ServerRequestFactory();

$request = $factory->createServerRequest(
    'GET',
    'https://example.com'
);
```

### Create a Request with Body

```php
use Philharmony\Http\Factory\RequestFactory;
use Philharmony\Http\Factory\StreamFactory;

$requestFactory = new RequestFactory();
$streamFactory = new StreamFactory();

$stream = $streamFactory->createStream('Hello, Philharmony');

$request = $requestFactory->createRequest('POST', 'https://example.com')
    ->withBody($stream);
```

### Create a Response

```php
use Philharmony\Http\Factory\ResponseFactory;

$response = (new ResponseFactory())->createResponse(200);
```

### Create a Stream

```php
use Philharmony\Http\Factory\StreamFactory;

$streamFactory = new StreamFactory();

// From string
$stream = $streamFactory->createStream('Hello');

// From file
$stream = $streamFactory->createStreamFromFile('/path/to/file.txt');

// From resource
$stream = $streamFactory->createStreamFromResource(fopen('php://temp', 'r+'))
```

### Create an Uploaded File

```php
use Philharmony\Http\Factory\UploadedFileFactory;
use Philharmony\Http\Factory\StreamFactory;

$stream = (new StreamFactory())->createStream('file content');

// From stream
$uploadedFile = (new UploadedFileFactory())->createUploadedFile(
    $stream,
    $stream->getSize(),
    UPLOAD_ERR_OK,
    'file.txt',
    'text/plain'
);

// From file
$uploadedFileFromFile = (new UploadedFileFactory())->createUploadedFileFromFile(
    fileOrStream: '/path/to/file.txt',
    size: null, // used filesize
    errorStatus: UPLOAD_ERR_OK,
    clientFilename: 'file.txt',
    clientMediaType: 'text/plain',
    fullPath: '/path/to/file.txt' // PHP 8.1+ support
);
```

### Create a URI

```php
use Philharmony\Http\Factory\UriFactory;

$uri = (new UriFactory())->createUri('https://example.com/path');
```

## 🧪 Testing

The package is strictly tested with PHPUnit 10 to ensure full compliance with HTTP standards and RFCs.

### Run Tests

```bash
composer test
```

### Code Coverage

```bash
composer test:coverage
```

## 🏗️ Static Analysis & Code Style

Verified with PHPStan Level 9 to ensure total type safety and prevent runtime errors.

```bash
composer phpstan
```

Check and fix code style (PSR-12):

```bash
composer cs-check
composer cs-fix
```

## 📄 License

This package is open-source and licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

Contributions, issues, and feature requests are welcome.

If you find a bug or have an idea for improvement, please open an issue or submit a pull request.

## ⭐ Support

If you find this package useful, please consider giving it a star on GitHub.
It helps the project grow and reach more developers.

