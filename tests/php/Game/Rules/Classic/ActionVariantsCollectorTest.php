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
    public function testGetActionVariantsForMovementAndAttacks()
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
              |  1  |  2  |  3  |  4  |
          _____________________________
           pl |  1  |  1  |     |  1  |
           1  |[ 1 ]|  1  |     |[ 2 ]|
              |     |     |     |     |
          _____________________________
           pl |     |     |     |     |
           2  |     |     |     |     |
              |     |     |     |     |
          _____________________________
           pl |     |     |  2  |  2  |
           3  |     |     | 10  | 10  |
              |     |     |     |     |
          _____________________________
           pl |     |     |  2  |  1  |
           4  |     |     |[10 ]|  1  |
              |     |     |     |     |
          _____________________________
         */
        $board = (new BoardBuilder())->build(Board::TYPE_SQUARE, 4, 4);
        // Player owned objects
        $tile1_1 = $board->getTileByCoordinates('1.1');
        $army1_1 = new Army($playerA, $tile1_1, 1);
        new Castle($tile1_1);

        $tile1_2 = $board->getTileByCoordinates('1.2');
        $army1_2 = new Army($playerA, $tile1_2, 1);

        $tile1_4 = $board->getTileByCoordinates('1.4');
        $army1_4 = new Army($playerA, $tile1_4, 2);
        new Castle($tile1_4);

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

        $this->assertFalse($variants->hasFoundCastle());
        $this->assertFalse($variants->hasAssaultCastle());
        $this->assertFalse($variants->hasDeductEnemyGarrison());
    }

    public function testGetActionVariantsForCastles()
    {
        $players = [
            $playerA = $this->createMock(PlayerInterface::class),
            $playerB = $this->createMock(PlayerInterface::class),
        ];
        /*
         Variants for player 1:
        - found castle at 1.4
        - take off enemy from 4.1
        - assault at 4.4
              |  1  |  2  |  3  |  4  |
          _____________________________
           pl |  1  |     |     |  1  |
           1  |  1  |     |     |  1  |
              |     |     |     |     |
          _____________________________
           pl |  2  |     |     |     |
           2  |  2  |     |     |     |
              |     |     |     |     |
          _____________________________
           pl |  1  |  1  |  1  |  1  |
           3  |  10 | 10  | 10  | 10  |
              |     |     |     |     |
          _____________________________
           pl |  2  |  1  |  1  |  2  |
           4  |[ 2 ]| 10  |  10 |[ 1 ]|
              |     |     |     |     |
          _____________________________
         */
        $board = (new BoardBuilder())->build(Board::TYPE_SQUARE, 4, 4);
        // Player owned objects
        $tile1_1 = $board->getTileByCoordinates('1.1');
        $army1_1 = new Army($playerA, $tile1_1, 1);

        $tile1_4 = $board->getTileByCoordinates('1.4');
        $army1_4 = new Army($playerA, $tile1_4, 1);

        $tile3_1 = $board->getTileByCoordinates('3.1');
        $army3_1 = new Army($playerA, $tile3_1, 10);

        $tile3_2 = $board->getTileByCoordinates('3.2');
        $army3_2 = new Army($playerA, $tile3_2, 10);

        $tile3_3 = $board->getTileByCoordinates('3.3');
        $army3_3 = new Army($playerA, $tile3_3, 10);

        $tile3_4 = $board->getTileByCoordinates('3.4');
        $army3_4 = new Army($playerA, $tile3_4, 10);

        $tile4_2 = $board->getTileByCoordinates('4.2');
        $army4_2 = new Army($playerA, $tile4_2, 10);

        $tile4_3 = $board->getTileByCoordinates('4.3');
        $army4_4 = new Army($playerA, $tile4_3, 10);
        // Enemy owned objects
        $tile2_1 = $board->getTileByCoordinates('2.1');
        $army2_1 = new Army($playerB, $tile2_1, 1);

        $tile4_1 = $board->getTileByCoordinates('4.1');
        $army4_1 = new Army($playerB, $tile4_1, 2);
        new Castle($tile4_1);

        $tile4_4 = $board->getTileByCoordinates('4.4');
        $army4_4 = new Army($playerB, $tile4_4, 1);
        new Castle($tile4_4);

        $game = new Game($players, $board);
        $variantsCollector = new ActionVariantsCollector($this->createMock(BattleService::class));
        $variants = $variantsCollector->getActionVariants($game);

        $this->assertTrue($variants->hasFoundCastle());
        $this->assertCount(1, $variants->getFoundCastleVariants());

        $this->assertTrue($variants->hasDeductEnemyGarrison());
        $this->assertCount(1, $variants->getDeductEnemyGarrisonVariants());
    }
}
