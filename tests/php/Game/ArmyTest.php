<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ArmyTest extends AbstractTestCase
{

    public function testMerge()
    {
        $owner = $this->createMock(Player::class);
        $army = new Army($owner, $this->createTile(), 1);
        $anotherArmy = new Army($owner, $this->createTile(), 2);

        $newArmy = Army::merge($army, $anotherArmy);
        $this->assertCount(3, $newArmy);
        $this->assertNull($army);
        $this->assertNull($anotherArmy);
    }
}