# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).
 
## Unreleased
### Added
- Board methods .getRows() and getColumns().
### Fixed
- Some exceptions namespaces: move from tests. 
### Internal
- Update phpunit to 6.4
- Extend all tests from internal supertype instead phpunit. 
 

## 1.0.0-alpha.1 - 2017-03-25
### Added
- AttackEnemy action. 
- BoardBuilder. 
- Basic class Board API implementation. 
- InitialSetting implementation. 

### Changed
- Rename Player class to PlayerInterface.
- Rename ReplenishArmy action to ReplenishGarrison. 
- Rename BaseCastle action to BuildCastle.
- Board constructor expects rows and columns.

## 1.0.0-alpha - 2017-03-19
### Added
- Most classes and logic. 
