<?php

namespace FreeElephants\HexoNardsTests\Game\Action;

use FreeElephants\HexoNards\Game\Action\AssaultCastle;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\PlayerInterface;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AssaultCastleTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(PlayerInterface::class);

        $tiles = $this->createGrid(2, 2);

        $defenderPlayer = $this->createMock(PlayerInterface::class);
        $defenderTile = $tiles['1.1'];
        $defenderArmy = new Army($defenderPlayer, $defenderTile, 1);
        $castle = new Castle($defenderTile);

        $assaulterTile = $tiles['1.2'];
        $assaulterArmy = new Army($player, $assaulterTile, 10);
        // surround castle
        $beseigingArmies = [
            new Army($player, $tiles['2.1'], 10),
            new Army($player, $tiles['2.2'], 10)
        ];

        $this->assertTrue($castle->isUnderSiege());

        $command = new AssaultCastle($castle, $assaulterArmy);
        $command->execute($player);

        $this->assertFalse($assaulterTile->hasArmy());
        $this->assertSame($assaulterArmy, $castle->getArmy());
        $this->assertTrue($defenderArmy->isDestroyed());
        $this->assertFalse($castle->isUnderSiege());
    }
}