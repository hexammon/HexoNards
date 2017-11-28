<?php

namespace Hexammon\HexoNardsTests\Game\Action;

use Hexammon\HexoNards\Game\Action\AttackEnemy;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AttackEnemyTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(PlayerInterface::class);
        $enemyPlayer = $this->createMock(PlayerInterface::class);
        $tiles = $this->createGrid(2, 2);
        $assaulterPosition = $tiles['1.1'];
        $assaultArmy = new Army($player, $assaulterPosition, 10);
        $enemyPosition = $tiles['1.1'];
        $enemyArmy = new Army($enemyPlayer, $enemyPosition, 10);

        $command = new AttackEnemy($assaultArmy, $enemyArmy);
        $command->execute($player);

        $this->assertCount(5, $assaultArmy);
        $this->assertCount(5, $enemyArmy);
    }
}