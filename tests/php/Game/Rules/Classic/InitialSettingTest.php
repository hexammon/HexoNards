<?php

namespace Hexammon\HexoNardsTests\Game\Rules\Classic;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\Hex\Tile;
use Hexammon\HexoNards\Game\Exception\UnsupportedConfigurationException;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\Classic\InitialSetting;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class InitialSettingTest extends AbstractTestCase
{

    public function testArrangePiecesFor2PlayersOnHexBoard_6_6()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $rows = $columns = [];
        $tiles = $this->createGrid(6, 6, Tile::class, $rows, $columns);
        $board = new Board(Board::TYPE_HEX, $tiles, $rows, $columns);
        $moveGenerator = $this->createMock(MoveGeneratorInterface::class);

        $game = new Game([$player1, $player2], $board, $this->createRuleSet($moveGenerator));
        $initialSettingService = new InitialSetting();
        $initialSettingService->arrangePieces($game);

        $player1castle = $board->getTileByCoordinates('1.6')->getCastle();
        $this->assertSame($player1, $player1castle->getOwner());
        $player2castle = $board->getTileByCoordinates('6.1')->getCastle();
        $this->assertSame($player2, $player2castle->getOwner());
    }

    public function testArrangePiecesFor4PlayersOnHexBoard_8_8()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $player3 = $this->createMock(PlayerInterface::class);
        $player4 = $this->createMock(PlayerInterface::class);
        $rows = $columns = [];
        $tiles = $this->createGrid(8, 8, Tile::class, $rows, $columns);
        $board = new Board(Board::TYPE_HEX, $tiles, $rows, $columns);
        $moveGenerator = $this->createMock(MoveGeneratorInterface::class);

        $game = new Game([$player1, $player2, $player3, $player4], $board, $this->createRuleSet($moveGenerator));
        $initialSettingService = new InitialSetting();
        $initialSettingService->arrangePieces($game);

        $player1castle = $board->getTileByCoordinates('1.8')->getCastle();
        $this->assertSame($player1, $player1castle->getOwner());
        $player2castle = $board->getTileByCoordinates('8.1')->getCastle();
        $this->assertSame($player2, $player2castle->getOwner());
    }
    public function testArrangePiecesFor2PlayersOnSquareBoard_6_6()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $rows = $columns = [];
        $tiles = $this->createGrid(6, 6, Tile::class, $rows, $columns);
        $board = new Board(Board::TYPE_SQUARE, $tiles, $rows, $columns);
        $moveGenerator = $this->createMock(MoveGeneratorInterface::class);

        $game = new Game([$player1, $player2], $board, $this->createRuleSet($moveGenerator));
        $initialSettingService = new InitialSetting();
        $initialSettingService->arrangePieces($game);

        $player1castle = $board->getTileByCoordinates('1.6')->getCastle();
        $this->assertSame($player1, $player1castle->getOwner());
        $player2castle = $board->getTileByCoordinates('6.1')->getCastle();
        $this->assertSame($player2, $player2castle->getOwner());
    }

    public function testArrangePiecesFor4PlayersOnSquareBoard_3_3()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $player3 = $this->createMock(PlayerInterface::class);
        $player4 = $this->createMock(PlayerInterface::class);
        $rows = $columns = [];
        $tiles = $this->createGrid(3, 3, Tile::class, $rows, $columns);
        $board = new Board(Board::TYPE_SQUARE, $tiles, $rows, $columns);
        $moveGenerator = $this->createMock(MoveGeneratorInterface::class);

        $game = new Game([$player1, $player2, $player3, $player4], $board, $this->createRuleSet($moveGenerator));
        $initialSettingService = new InitialSetting();
        $initialSettingService->arrangePieces($game);

        $player1Castle = $board->getTileByCoordinates('1.3')->getCastle();
        $this->assertSame($player1, $player1Castle->getOwner());
        $player2Castle = $board->getTileByCoordinates('3.1')->getCastle();
        $this->assertSame($player2, $player2Castle->getOwner());
        $player3Castle = $board->getTileByCoordinates('1.1')->getCastle();
        $this->assertSame($player3, $player3Castle->getOwner());
        $player4Castle = $board->getTileByCoordinates('3.3')->getCastle();
        $this->assertSame($player4, $player4Castle->getOwner());
    }
    public function testArrangePiecesFor4PlayersOnSquareBoard_8_8()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $player3 = $this->createMock(PlayerInterface::class);
        $player4 = $this->createMock(PlayerInterface::class);
        $rows = $columns = [];
        $tiles = $this->createGrid(8, 8, Tile::class, $rows, $columns);
        $board = new Board(Board::TYPE_SQUARE, $tiles, $rows, $columns);
        $moveGenerator = $this->createMock(MoveGeneratorInterface::class);

        $game = new Game([$player1, $player2, $player3, $player4], $board, $this->createRuleSet($moveGenerator));
        $initialSettingService = new InitialSetting();
        $initialSettingService->arrangePieces($game);

        $player1castle = $board->getTileByCoordinates('1.8')->getCastle();
        $this->assertSame($player1, $player1castle->getOwner());
        $player2castle = $board->getTileByCoordinates('8.1')->getCastle();
        $this->assertSame($player2, $player2castle->getOwner());
    }

    public function testUnsupportedNumberOfPlayersException()
    {
        $initialSettingService = new InitialSetting();
        $game = $this->createMock(Game::class);
        $game->method('getPlayers')->willReturn([
            $this->createMock(PlayerInterface::class),
            $this->createMock(PlayerInterface::class),
            $this->createMock(PlayerInterface::class),
        ]);
        $this->expectException(UnsupportedConfigurationException::class);
        $initialSettingService->arrangePieces($game);
    }
}
