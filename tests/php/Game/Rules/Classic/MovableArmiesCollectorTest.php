<?php
declare(strict_types=1);


namespace Hexammon\HexoNardsTests\Game\Rules\Classic;

use DeepCopy\f001\A;
use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\BoardBuilder;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\Classic\MovableArmiesCollector;
use Hexammon\HexoNardsTests\AbstractTestCase;

class MovableArmiesCollectorTest extends AbstractTestCase
{

    public function testGetMovableArmies()
    {
        $player = $this->createMock(PlayerInterface::class);
        $anotherPlayer = $this->createMock(PlayerInterface::class);
        $collector = new MovableArmiesCollector();
        /*
        Rules:
         - 1.1 - can not be moved - because last unit in garrison
         - 1.2 - can be moved - army in field
         - 1.4 - can be moved - with garrison split
         - 4.4 - can not be moved - because blocked by enemy
              |  1  |  2  |  3  |  4  |
          _____________________________
           pl |  1  |  1  |     |  1  |
           1  |[ 1 ]|     |     |[ 2 ]|
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
        $army1_1 = new Army($player, $tile1_1, 1);
        new Castle($tile1_1);

        $tile1_2 = $board->getTileByCoordinates('1.2');
        $army1_2 = new Army($player, $tile1_2, 1);

        $tile1_4 = $board->getTileByCoordinates('1.4');
        $army1_4 = new Army($player, $tile1_4, 2);

        $tile4_4 = $board->getTileByCoordinates('4.4');
        $army4_4 = new Army($player, $tile4_4, 1);
        // Enemy owned objects
        $tile3_3 = $board->getTileByCoordinates('3.3');
        $army3_3 = new Army($anotherPlayer, $tile3_3, 10);

        $tile3_4 = $board->getTileByCoordinates('3.4');
        $army3_4 = new Army($anotherPlayer, $tile3_4, 10);

        $tile4_3 = $board->getTileByCoordinates('4.3');
        $army4_3 = new Army($anotherPlayer, $tile4_3, 10);
        new Castle($tile4_3);

        $playerMovableArmies = $collector->getMovableArmies($board, $player);
        $this->assertCount(2, $playerMovableArmies);
        $this->assertContains($army1_2, $playerMovableArmies);
        $this->assertContains($army1_4, $playerMovableArmies);
    }
}
