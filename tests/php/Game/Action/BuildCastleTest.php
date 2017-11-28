<?php

namespace Hexammon\HexoNardsTests\Game\Action;

use Hexammon\HexoNards\Game\Action\BuildCastle;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNardsTests\AbstractTestCase;

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