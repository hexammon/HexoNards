<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Board\Square\Tile;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\Exception\ConstructOnOccupiedTileException;
use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class CastleTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructingAndGetters()
    {
        $owner = $this->createMock(Player::class);
        $tile = $this->createMock(Tile::class);

        $castle = new Castle($owner, $tile);

        $this->assertSame($owner, $castle->getOwner());
        $this->assertSame($tile, $castle->getTile());
    }

    public function testConstructingOnOccupiedPlaceException()
    {
        $owner = $this->createMock(Player::class);
        $tile = $this->createMock(Tile::class);
        $tile->method('hasCastle')->willReturn(true);
        $this->expectException(ConstructOnOccupiedTileException::class);
        new Castle($owner, $tile);
    }

    public function testIsUnderSiegeFalse()
    {
        $owner = $this->createMock(Player::class);
        $tile = $this->createMock(Tile::class);

        $emptyTile = $this->createMock(Tile::class);
        $emptyTile->method('hasArmy')->willReturn(false);
        $tile->method('getNearestTiles')->willReturn([
            $emptyTile
        ]);

        $castle = new Castle($owner, $tile);

        $this->assertFalse($castle->isUnderSiege());
    }

    public function testIsUnderSiegeTrue()
    {
        $owner = $this->createMock(Player::class);
        $tile = $this->createMock(Tile::class);
        $enemyOccupiedTile = $this->createMock(Tile::class);
        $enemyOccupiedTile->method('hasArmy')->willReturn(true);
        $enemy = $this->createMock(Army::class);
        $enemy->method('isSameOwner')->willReturn(false);
        $enemyOccupiedTile->method('getArmy')->willReturn($enemy);
        $tile->method('getNearestTiles')->willReturn([
            $enemyOccupiedTile
        ]);

        $castle = new Castle($owner, $tile);

        $this->assertTrue($castle->isUnderSiege());
    }
}