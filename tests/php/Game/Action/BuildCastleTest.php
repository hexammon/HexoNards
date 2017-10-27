<?php

namespace FreeElephants\HexoNardsTests\Game\Action;

use FreeElephants\HexoNards\Game\Action\BuildCastle;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\PlayerInterface;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BuildCastleTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(PlayerInterface::class);
        $tile = $this->createTileWithMocks();
        $garrison = $this->createMock(Army::class);
        $garrison->method('getOwner')->willReturn($player);
        $tile->setArmy($garrison);

        $command = new BuildCastle($tile);
        $command->execute($player);

        $this->assertTrue($tile->hasCastle());
        $this->assertSame($garrison, $tile->getCastle()->getArmy());
    }
}