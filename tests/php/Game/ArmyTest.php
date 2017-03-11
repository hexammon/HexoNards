<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ArmyTest extends \PHPUnit_Framework_TestCase
{

    public function testMoveWithJoin()
    {
        $owner = $this->createMock(Player::class);
        $army = new Army($owner, 1);
        $anotherArmy = new Army($owner, 2);

        $newArmy = $army->join($anotherArmy);
        $this->assertCount(3, $newArmy);
    }
}