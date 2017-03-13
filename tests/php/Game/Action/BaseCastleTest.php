<?php

namespace FreeElephants\HexoNardsTests\Game\Action;

use FreeElephants\HexoNards\Game\Action\BaseCastle;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseCastleTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(Player::class);
        $tile = $this->createTile();
        $garrison = $this->createMock(Army::class);
        $garrison->method('getOwner')->willReturn($player);
        $tile->setArmy($garrison);

        $command = new BaseCastle($tile);
        $command->execute($player);

        $this->assertTrue($tile->hasCastle());
        $this->assertSame($garrison, $tile->getCastle()->getArmy());
    }
}