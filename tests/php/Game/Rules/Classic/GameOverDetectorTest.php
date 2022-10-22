<?php

namespace Hexammon\HexoNardsTests\Game\Rules\Classic;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\Column;
use Hexammon\HexoNards\Board\Hex\Tile;
use Hexammon\HexoNards\Board\Row;
use Hexammon\HexoNards\Game\Army;
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
