<?php

namespace FreeElephants\HexoNardsTests\Game\Action;

use FreeElephants\HexoNards\Game\Action\Exception\InapplicableActionException;
use FreeElephants\HexoNards\Game\Action\MergeArmy;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\PlayerInterface;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MergeArmyTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(PlayerInterface::class);
        $tiles = $this->createGrid(2, 2);
        $sourceTile = $tiles['1.1'];
        $targetTile = $tiles['1.2'];
        $sourceArmy = new Army($player, $sourceTile, 3);
        $targetArmy = new Army($player, $targetTile, 4);

        $command = new MergeArmy($sourceArmy, $targetArmy);
        $command->execute($player);

        $this->assertCount(7, $targetTile->getArmy());
        $this->assertNull($sourceArmy);
        $this->assertNull($targetArmy);
    }

    public function testMergeWithEnemy()
    {
        $player = $this->createMock(PlayerInterface::class);
        $enemy = $this->createMock(PlayerInterface::class);
        $tiles = $this->createGrid(2, 2);
        $sourceTile = $tiles['1.1'];
        $targetTile = $tiles['1.2'];
        $sourceArmy = new Army($player, $sourceTile, 3);
        $targetArmy = new Army($enemy, $targetTile, 4);

        $command = new MergeArmy($sourceArmy, $targetArmy);
        $this->expectException(InapplicableActionException::class);
        $command->execute($player);
    }
}