# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.1

### Added

- [#3](https://github.com/rapidmail/rapidmail-apiv3-client-php/pull/3) adds support for PHP 7.4.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#4](https://github.com/rapidmail/rapidmail-apiv3-client-php/pull/4) fixes a bug where setting the "updated_since"
filter when listing mailings would instead apply a "created_since" filter (Issue #2)

- [#5](https://github.com/rapidmail/rapidmail-apiv3-client-php/pull/5) fixes a bug where multiple values specified
as status filter when querying mailings would be passed to the API as a CSV-string rather than an array (Issue #1)