# Changelog
All notable changes to this project will be documented in this file.

## [6.4.1] - 2021-10-06
- Fixed: php 7.4+ only syntax

## [6.4.0] - 2021-09-01

- Added: php8 support

## [6.3.3] - 2021-07-14

- fixed ondelete_callbacks to have second parameter 0 for undoId

## [6.3.2] - 2020-09-25

- added gitignore
- removed .idea

## [6.3.1] - 2020-09-18

#### Added
- hook to modifyDc in `ModuleReader`

## [6.3.0] - 2019-10-01

#### Added
- support for formhybrid custom form id suffix

## [6.2.1] - 2019-04-02

#### Fixed
- toggle `tl_calendar_event.memberAuthor` field shown when `tl_calendar_event.useMemberAuthor` selector is active
- toggle `tl_news.memberAuthor` field shown when `tl_news.useMemberAuthor` selector is active

## [6.2.0] - 2018-11-28

#### Added
- TL_COMPONENT support in order to disable js, css assets on demand

## [6.1.1] - 2018-11-23

#### Fixed
- callback error with newer php versions in ReaderForm::onSubmitCallback

## [6.1.0] - 2018-05-17

#### Added
- support for heimrichhannot/contao-privacy

## [6.0.2] - 2018-03-05

#### Changed
- added minified version of js

## [6.0.1] - 2018-02-16

- load `tl_module` fields of type `pageTree` related pages `lazy`

## [6.0.0] - 2018-02-06

### Changed
- increased dependency to version 4.+ of `heimrichhannot/contao-formhybrid_list` 

## [5.0.0] - 2017-11-21

### Added
- sessionID/author check to list module
- support for create mode in modal

### Fixed
- sortingHeader
- filter palette issues
- replace echo by <?=

## [4.2.0] - 2017-08-18

### Removed
- addImage -> refactor a better in future

## [4.1.0] - 2017-08-11

### Added
- OptInToken configuration to ModuleReader
- english translation for tl_module palette labels

## [4.0.1] - 2017-08-01

### Changed
- member callback to contain email and ID

## [4.0.0] - 2017-07-25

### Changed
- outsourced modal handling to heimrichhannot/contao-modal (TODO create)

## [3.4.4] - 2017-05-09

### Fixed
- php 7 support
- field lengths

## [3.4.3] - 2017-04-26

### Added
- columns options to frontendedit_list_item_default.html5

## [3.4.2] - 2017-04-11

### Added
- `tl_module.formHybridForcePaletteRelation` added to `MODULE_FRONTENDEDIT_READER`
- php7 support

## [3.4.1] - 2017-04-06

### Fixed
- callback issues

## [3.4.0] - 2017-04-05

### Added
- proximity search

### Changed
- template -> wrapper data attributes are now calculated in the module

## [3.3.5] - 2017-03-02

### Fixed
- removed formHybridAsync from validator

## [3.3.4] - 2017-02-24

### Fixed
- memberAuthor relation

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
