# Change Log
All notable changes to this project will be documented in this file.

## [3.2.31] - 2016-11-11

### Fixed
- noPermission ajax response only, if request is formhybrid ajax related

## [3.2.30] - 2016-11-08

### Fixed
- hash management

## [3.2.29] - 2016-11-08

### Fixed
- ModuleValidator now also supports async behavior

## [3.2.27] - 2016-11-03

### Added
- ModuleReader: throw Exception when General::PROPERTY_AUTHOR_TYPE not existing for current table

### Fixed
- ModuleReader: on noPermission and ajax request, return ResponseError
