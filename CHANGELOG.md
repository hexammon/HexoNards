# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).
 
## [Unreleased] 
### Fixed
- One unit army moving: bug with zero-size army after move.

## 1.0.0-alpha.4 - 2017-11-29
### Added 
- GameOverDetectorInterface with Classic implementation.  

## 1.0.0-alpha.3 - 2017-11-27
### Changed
- Transfer repository from [Free Elephants](https://github.com/FreeElephants) to [Hexammon](https://github.com/Hexammon) 
 
 
## 1.0.0-alpha.2 - 2017-10-28
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
