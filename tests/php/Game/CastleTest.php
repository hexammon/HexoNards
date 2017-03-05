<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Board\Tile;
use FreeElephants\HexoNards\Game\Castle;
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
}