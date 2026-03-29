# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/).

---
## [1.1.0] - 2026-03-29

### Added
- Support for `philharmony/http-psr-extension`
- `UploadedFileFactoryFromFileInterface` integration

### Tests
- change `StreamFactoryTest::testCreateStreamFromFileThrowsOnNonExistentFile` remove `error_handler`

---

## [1.0.0] - 2026-03-26

### Added
- Initial PSR-17 HTTP factory implementation:
  - `RequestFactory`
  - `ResponseFactory`
  - `ServerRequestFactory`
  - `StreamFactory`
  - `UploadedFileFactory`
  - `UriFactory`
- Full compatibility with PSR-17 interfaces
- Integration with `philharmony/http-message` package
- Support for streams, files, and uploaded files
- Comprehensive unit test coverage

[1.1.0]: https://github.com/philharmonytech/http-factory/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/philharmonytech/http-factory/releases/tag/v1.0.0
