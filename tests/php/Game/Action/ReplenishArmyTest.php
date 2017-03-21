<?php

namespace FreeElephants\HexoNardsTests\Game\Action;

use FreeElephants\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use FreeElephants\HexoNards\Game\Action\ReplenishArmy;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\PlayerInterface;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ReplenishArmyTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(PlayerInterface::class);
        $army = new Army($player, $this->createTileWithMocks(), 10);

        $command = new ReplenishArmy($army, 2);
        $command->execute($player);

        $this->assertCount(12, $army);
    }

    public function testReplenishForeignArmyException()
    {
        $player = $this->createMock(PlayerInterface::class);
        $otherPlayer = $this->createMock(PlayerInterface::class);
        $army = new Army($otherPlayer, $this->createTileWithMocks(), 10);

        $command = new ReplenishArmy($army, 2);

        $this->expectException(TouchForeignOwnException::class);
        $command->execute($player);
    }

}