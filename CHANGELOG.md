# Changelog
All notable changes to this project will be documented in this file.

## [3.3.5] - 2017-03-02

### Fixed
- removed formHybridAsync from validator

## [3.3.4] - 2017-02-24

### Fixed
- memberAUthor relation

## [3.3.3] - 2017-02-22

### Fixed
- template
- changed array() to []

## [3.3.2] - 2016-12-01

### Fixed
- forceCreate within ajax request. Set only to true if no intId is in FormSession

## [3.3.1] - 2016-11-30

### Fixed
- forceCreate (noIdBehavior = create) only set true if is formhybrid related ajax request

## [3.3.0] - 2016-11-21

### Added
- exporter support

## [3.2.32] - 2016-11-14

### Fixed
- always create a new entity if noIdBehavior = create (default), required by ajax requests

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