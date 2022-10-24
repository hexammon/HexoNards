<?php
declare(strict_types=1);


namespace Hexammon\HexoNardsTests\Game\Rules\Classic;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\BoardBuilder;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\BattleService;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\Classic\ActionVariantsCollector;
use Hexammon\HexoNardsTests\AbstractTestCase;

class ActionVariantsCollectorTest extends AbstractTestCase
{
    public function testGetActionVariants()
    {
        $players = [
            $playerA = $this->createMock(PlayerInterface::class),
            $playerB = $this->createMock(PlayerInterface::class),
        ];
        /*
         Variants for player 1:
          - spawn at 1.1
          - spawn at 1.4
          - move from 1.2
          - move from 1.4
          - attack enemy at 3.3
          - attack enemy at 3.4
          - build castle on 1.7
              |  1  |  2  |  3  |  4  |  5  |  6  |  7  |
          _______________________________________________
           pl |  1  |  1  |     |  1  |     |     |  1  |
           1  |[ 1 ]|  1  |     |[ 2 ]|     |     |  1  |
              |     |     |     |     |     |     |     |
          _______________________________________________
           pl |     |     |     |     |     |     |     |
           2  |     |     |     |     |     |     |     |
              |     |     |     |     |     |     |     |
          _______________________________________________
           pl |     |     |  2  |  2  |     |     |     |
           3  |     |     | 10  | 10  |     |     |     |
              |     |     |     |     |     |     |     |
          _______________________________________________
           pl |     |     |  2  |  1  |     |     |     |
           4  |     |     |[10 ]|  1  |     |     |     |
              |     |     |     |     |     |     |     |
          _______________________________________________
         */
        $board = (new BoardBuilder())->build(Board::TYPE_SQUARE, 4, 7);
        // Player owned objects
        $tile1_1 = $board->getTileByCoordinates('1.1');
        $army1_1 = new Army($playerA, $tile1_1, 1);
        new Castle($tile1_1);

        $tile1_2 = $board->getTileByCoordinates('1.2');
        $army1_2 = new Army($playerA, $tile1_2, 1);

        $tile1_4 = $board->getTileByCoordinates('1.4');
        $army1_4 = new Army($playerA, $tile1_4, 2);

        $tile4_4 = $board->getTileByCoordinates('4.4');
        $army4_4 = new Army($playerA, $tile4_4, 1);
        // Enemy owned objects
        $tile3_3 = $board->getTileByCoordinates('3.3');
        $army3_3 = new Army($playerB, $tile3_3, 10);

        $tile3_4 = $board->getTileByCoordinates('3.4');
        $army3_4 = new Army($playerB, $tile3_4, 10);

        $tile4_3 = $board->getTileByCoordinates('4.3');
        $army4_3 = new Army($playerB, $tile4_3, 10);
        new Castle($tile4_3);
        $game = new Game($players, $board);

        $variantsCollector = new ActionVariantsCollector($this->createMock(BattleService::class));
        $variants = $variantsCollector->getActionVariants($game);

        $this->assertTrue($variants->hasSpawn());
        $this->assertTrue($variants->hasMovement());
        $this->assertTrue($variants->hasAttack());
        $this->assertTrue($variants->hasBuildCastle());

        $this->assertFalse($variants->hasAssaultCastle());
        $this->assertFalse($variants->hasTakeOffEnemyGarrison());
    }
}
