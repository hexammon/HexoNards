<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Board\Square\Tile;
use FreeElephants\HexoNards\Exception\DomainException;
use FreeElephants\HexoNards\Exception\InvalidArgumentException;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\Exception\MoveToOccupiedTileException;
use FreeElephants\HexoNards\Game\PlayerInterface;
use FreeElephants\HexoNardsTests\AbstractTestCase;
use FreeElephants\HexoNardsTests\Game\Exception\TooMuchDistanceException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ArmyTest extends AbstractTestCase
{

    public function testMerge()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $army = new Army($owner, $this->createTileWithMocks(), 1);
        $anotherArmy = new Army($owner, $this->createTileWithMocks(), 2);

        $newArmy = Army::merge($army, $anotherArmy);

        $this->assertCount(3, $newArmy);
        $this->assertNull($army);
        $this->assertNull($anotherArmy);
    }

    public function testMergeWithEnemy()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $enemy = $this->createMock(PlayerInterface::class);
        $army = new Army($owner, $this->createTileWithMocks(), 1);
        $anotherArmy = new Army($enemy, $this->createTileWithMocks(), 2);

        $this->expectException(DomainException::class);
        Army::merge($army, $anotherArmy);
    }

    public function testMove()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $initialTile = $this->createMock(Tile::class);
        $newTile = $this->createTileWithMocks();
        $initialTile->method('getNearestTiles')->willReturn([$newTile]);

        $army = new Army($owner, $initialTile, 1);
        $army->move($newTile);

        $this->assertSame($newTile, $army->getTile());
        $this->assertFalse($initialTile->hasArmy());
    }

    public function testMoveTooMuchDistanceException()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $initialTile = $this->createTileWithMocks();
        $army = new Army($owner, $initialTile, 1);

        $newTile = $this->createTileWithMocks();
        $this->expectException(TooMuchDistanceException::class);
        $army->move($newTile);
    }

    public function testMoveOnOccupiedTileException()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $initialTile = $this->createTileWithMocks();
        $army = new Army($owner, $initialTile, 1);

        $newTile = $this->createTileWithMocks();
        $newTile->setArmy($this->createMock(Army::class));
        $this->expectException(MoveToOccupiedTileException::class);
        $army->move($newTile);
    }

    public function testReplenish()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $army = new Army($owner, $this->createTileWithMocks(), 1);

        $army->replenish(2);

        $this->assertCount(3, $army);
    }

    public function testReplenishInSiegeException()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $castle = $this->createMock(Castle::class);
        $castle->method('isUnderSiege')->willReturn(true);
        $tile = $this->createTileWithMocks();
        $tile->setCastle($castle);

        $army = new Army($owner, $tile, 1);
        $this->expectException(DomainException::class);
        $army->replenish(1);

    }

    public function testReplenishNegativeValueException()
    {
        $owner = $this->createMock(PlayerInterface::class);
        $army = new Army($owner, $this->createTileWithMocks(), 1);
        $this->expectException(InvalidArgumentException::class);
        $army->replenish(-2);
    }

}