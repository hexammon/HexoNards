<?php

namespace Hexammon\HexoNardsTests\Game;

use Hexammon\HexoNards\Board\Square\Tile;
use Hexammon\HexoNards\Exception\DomainException;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\Exception\ConstructOnOccupiedTileException;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class CastleTest extends AbstractTestCase
{

    public function testConstructingAndGetters()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $tile = $this->createMock(Tile::class);
        $tile->method('hasArmy')->willReturn(true);
        $ownerArmy = $this->createMock(Army::class);
        $ownerArmy->method('getOwner')->willReturn($owner);
        $tile->method('getArmy')->willReturn($ownerArmy);

        $castle = new Castle($tile);

        $this->assertSame($owner, $castle->getOwner());
        $this->assertSame($tile, $castle->getTile());
    }

    public function testConstructingOnOccupiedPlaceException()
    {
        $tile = $this->createMock(Tile::class);
        $tile->method('hasCastle')->willReturn(true);
        $tile->method('hasArmy')->willReturn(true);
        $this->expectException(ConstructOnOccupiedTileException::class);
        new Castle($tile);
    }


    public function testConstructingOnTileWithoutArmyException()
    {
        $tile = $this->createMock(Tile::class);
        $tile->method('hasCastle')->willReturn(false);
        $tile->method('hasArmy')->willReturn(false);

        $this->expectException(DomainException::class);
        new Castle($tile);
    }

    public function testIsUnderSiegeFalse()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $tile = $this->createMock(Tile::class);

        $emptyTile = $this->createMock(Tile::class);
        $emptyTile->method('hasArmy')->willReturn(false);
        $tile->method('getNearestTiles')->willReturn([
            $emptyTile
        ]);
        $tile->method('hasArmy')->willReturn(true);
        $ownerArmy = $this->createMock(Army::class);
        $ownerArmy->method('getOwner')->willReturn($owner);
        $tile->method('getArmy')->willReturn($ownerArmy);

        $castle = new Castle($tile);

        $this->assertFalse($castle->isUnderSiege());
    }

    public function testIsUnderSiegeTrue()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $tile = $this->createMock(Tile::class);
        $enemyOccupiedTile = $this->createMock(Tile::class);
        $enemyOccupiedTile->method('hasArmy')->willReturn(true);
        $enemyArmy = $this->createMock(Army::class);
        $enemyArmy->method('isSameOwner')->willReturn(false);
        $enemyOccupiedTile->method('getArmy')->willReturn($enemyArmy);
        $tile->method('getNearestTiles')->willReturn([
            $enemyOccupiedTile
        ]);
        $tile->method('hasArmy')->willReturn(true);
        $ownerArmy = $this->createMock(Army::class);
        $ownerArmy->method('getOwner')->willReturn($owner);
        $tile->method('getArmy')->willReturn($ownerArmy);

        $castle = new Castle($tile);

        $this->assertTrue($castle->isUnderSiege());
    }
}