<?php
declare(strict_types=1);


namespace Hexammon\HexoNardsTests\Game\Action\Variant;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\BoardBuilder;
use Hexammon\HexoNards\Game\Action\Variant\Movement;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\Classic\RuleSet;
use Hexammon\HexoNardsTests\AbstractTestCase;

class MovementTest extends AbstractTestCase
{
    public function testMoveWithMergeInCastle()
    {
        $players = [
            $playerA = $this->createMock(PlayerInterface::class),
            $playerB = $this->createMock(PlayerInterface::class),
        ];
        /*
         Variants for player 1:
          - spawn at 1.1
          - spawn at 1.4
          - move from 1.2 to
            - 1.1
            - 2.1
            - 2.2
            - 2.3
            - 1.3
          - move from 1.4 to
            - 1.3
            - 2.3
            - 2.4
          - attack enemy at 3.3
          - attack enemy at 3.4
              |  1  |  2  |  3  |  4  |
          _____________________________
           pl |     |     |  1  |  1  |
           1  |     |     | 12  |[ 3 ]|
              |     |     |     |     |
          _____________________________
           pl |     |     |     |     |
           2  |     |     |     |     |
              |     |     |     |     |
          _____________________________
           pl |     |     |     |     |
           3  |     |     |     |     |
              |     |     |     |     |
          _____________________________
           pl |  2  |     |     |     |
           4  |[ 1 ]|     |     |     |
              |     |     |     |     |
          _____________________________
         */
        $board = (new BoardBuilder())->build(Board::TYPE_SQUARE, 4, 4);
        // Player owned objects
        $tile1_3 = $board->getTileByCoordinates('1.3');
        $army1_3 = new Army($playerA, $tile1_3, 12);

        $tile1_4 = $board->getTileByCoordinates('1.4');
        $army1_4 = new Army($playerA, $tile1_4, 3);
        new Castle($tile1_4);
        // Enemy
        $tile4_1 = $board->getTileByCoordinates('4.1');
        $army4_1 = new Army($playerB, $tile4_1, 1);
        new Castle($tile4_1);

        $variant = new Movement($tile1_4, $tile1_3);
        $variant->setUnitsVolume(2);
        $action = $variant->makeAction();

        $game  = new Game($players, $board, new RuleSet());
        $game->invoke($action);
        $this->assertCount(14, $tile1_3->getArmy());
        $this->assertCount(1, $tile1_4->getArmy());
    }
}
