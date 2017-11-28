<?php

namespace Hexammon\HexoNardsTests\Game\Action;

use Hexammon\HexoNards\Game\Action\ReplenishGarrison;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ReplenishGarrisonTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(PlayerInterface::class);
        $army = new Army($player, $this->createTileWithMocks(), 10);

        $command = new ReplenishGarrison($army, 2);
        $command->execute($player);

        $this->assertCount(12, $army);
    }

    public function testReplenishForeignArmyException()
    {
        $player = $this->createMock(PlayerInterface::class);
        $otherPlayer = $this->createMock(PlayerInterface::class);
        $army = new Army($otherPlayer, $this->createTileWithMocks(), 10);

        $command = new ReplenishGarrison($army, 2);

        $this->expectException(TouchForeignOwnException::class);
        $command->execute($player);
    }

}