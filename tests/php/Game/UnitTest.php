<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Board\Tile;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNards\Game\Unit;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class UnitTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructingAndGetters()
    {
        $owner = $this->createMock(Player::class);
        $tile = $this->createMock(Tile::class);
        $unit = new Unit($owner, $tile);

        $this->assertSame($owner, $unit->getOwner());
        $this->assertSame($tile, $unit->getTile());
    }

    public function testMove()
    {
        $owner = $this->createMock(Player::class);
        $initialTile = $this->createMock(Tile::class);
        $unit = new Unit($owner, $initialTile);
        $newTile = $this->createMock(Tile::class);

        $unit->move($newTile);

        $this->assertSame($newTile, $unit->getTile());
    }
}