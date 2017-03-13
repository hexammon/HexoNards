<?php

namespace FreeElephants\HexoNardsTests\Game\Action;

use FreeElephants\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use FreeElephants\HexoNards\Game\Action\ReplenishArmy;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ReplenishArmyTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(Player::class);
        $army = new Army($player, $this->createTile(), 10);

        $command = new ReplenishArmy($army, 2);
        $command->execute($player);

        $this->assertCount(12, $army);
    }

    public function testReplenishForeignArmyException()
    {
        $player = $this->createMock(Player::class);
        $otherPlayer = $this->createMock(Player::class);
        $army = new Army($otherPlayer, $this->createTile(), 10);

        $command = new ReplenishArmy($army, 2);
        $this->expectException(TouchForeignOwnException::class);
        $command->execute($player);
    }

}