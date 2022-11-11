<?php

namespace Hexammon\HexoNardsTests\Game\Rules\Classic;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\BoardBuilder;
use Hexammon\HexoNards\Board\Column;
use Hexammon\HexoNards\Board\Hex\Tile;
use Hexammon\HexoNards\Board\Row;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\Classic\GameOverDetector;
use Hexammon\HexoNards\Game\Rules\Exception\GameNotOverException;
use Hexammon\HexoNardsTests\AbstractTestCase;

class GameOverDetectorTest extends AbstractTestCase
{

    public function testIsOver_with_one_player_armies()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $board = $this->createMock(Board::class);
        $tile1 = new Tile(new Row(1), new Column(1));
        new Army($player1, $tile1, 1);
        $tile2 = new Tile(new Row(2), new Column(2));
        new Army($player1, $tile2, 1);
        $board->method('getTiles')->willReturn([
            $tile1,
            $tile2,
        ]);
        $movesGenerator = $this->createMock(MoveGeneratorInterface::class);
        $game = new Game([
            $player1,
            $player2
        ], $board, $this->createRuleSet($movesGenerator));
        $detector = new GameOverDetector();
        $this->assertTrue($detector->isOver($game));
    }

    public function testIsOver_with_two_players_armies()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $board = $this->createMock(Board::class);
        $tile1 = new Tile(new Row(1), new Column(1));
        new Army($player1, $tile1, 1);
        $tile2 = new Tile(new Row(2), new Column(2));
        new Army($player2, $tile2, 1);
        $board->method('getTiles')->willReturn([
            $tile1,
            $tile2
        ]);
        $movesGenerator = $this->createMock(MoveGeneratorInterface::class);
        $game = new Game([
            $player1,
            $player2
        ], $board, $this->createRuleSet($movesGenerator));

        $detector = new GameOverDetector();
        $this->assertFalse($detector->isOver($game));
    }

    public function testIsOver_last_unit_blocked()
    {
        $players = [
            $playerA = $this->createMock(PlayerInterface::class),
            $playerB = $this->createMock(PlayerInterface::class),
        ];
        /*
         No more variants for player A:
              |  1  |  2  |  3  |  4  |
          _____________________________
           pl |     |     |  B  |  A  |
           1  |     |     |  1  |[ 1 ]|
              |     |     |     |     |
          _____________________________
           pl |     |     |  B  |  B  |
           2  |     |     |  1  |  1  |
              |     |     |     |     |
          _____________________________
           pl |     |     |     |     |
           3  |     |     |     |     |
              |     |     |     |     |
          _____________________________
           pl |     |     |     |     |
           4  |     |     |     |     |
              |     |     |     |     |
          _____________________________
         */
        $board = (new BoardBuilder())->build(Board::TYPE_SQUARE, 4, 4);
        // Player 1 owned objects
        $tile1_4 = $board->getTileByCoordinates('1.4');
        $army1_4 = new Army($playerA, $tile1_4, 1);
        new Castle($tile1_4);

        $tile1_3 = $board->getTileByCoordinates('1.3');
        $army1_3 = new Army($playerB, $tile1_3, 1);

        $tile2_3 = $board->getTileByCoordinates('2.3');
        $army2_3 = new Army($playerB, $tile2_3, 1);

        $tile2_4 = $board->getTileByCoordinates('2.4');
        $army2_4 = new Army($playerB, $tile2_4, 1);

        $movesGenerator = $this->createMock(MoveGeneratorInterface::class);
        $game = new Game([
            $playerA,
            $playerB
        ], $board, $this->createRuleSet($movesGenerator));

        $detector = new GameOverDetector();
        $this->assertTrue($detector->isOver($game));
    }

    public function testGetWinner()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $board = $this->createMock(Board::class);
        $tile1 = new Tile(new Row(1), new Column(1));
        new Army($player1, $tile1, 1);
        $tile2 = new Tile(new Row(2), new Column(2));
        new Army($player1, $tile2, 1);
        $board->method('getTiles')->willReturn([
            $tile1,
            $tile2,
        ]);
        $movesGenerator = $this->createMock(MoveGeneratorInterface::class);
        $game = new Game([
            $player1,
            $player2
        ], $board, $this->createRuleSet($movesGenerator));
        $detector = new GameOverDetector();
        $this->assertSame($player1, $detector->getWinner($game));
    }

    public function testGetWinner_GameNotOverException()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $board = $this->createMock(Board::class);
        $tile1 = new Tile(new Row(1), new Column(1));
        new Army($player1, $tile1, 1);
        $tile2 = new Tile(new Row(2), new Column(2));
        new Army($player2, $tile2, 1);
        $board->method('getTiles')->willReturn([
            $tile1,
            $tile2
        ]);
        $movesGenerator = $this->createMock(MoveGeneratorInterface::class);
        $game = new Game([
            $player1,
            $player2
        ], $board, $this->createRuleSet($movesGenerator));

        $detector = new GameOverDetector();
        $this->expectException(GameNotOverException::class);
        $detector->getWinner($game);
    }
}
