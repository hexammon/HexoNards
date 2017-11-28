<?php

namespace Hexammon\HexoNardsTests\Game\Rules;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\Hex\Tile;
use Hexammon\HexoNards\Game\Exception\UnsupportedConfigurationException;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\ClassicInitialSetting;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ClassicInitialSettingTest extends AbstractTestCase
{

    public function testArrangePiecesFor2Players()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $rows = $columns = [];
        $tiles = $this->createGrid(6, 6, Tile::class, $rows, $columns);
        $board = new Board(Board::TYPE_HEX, $tiles, $rows, $columns);
        $moveGenerator = $this->createMock(MoveGeneratorInterface::class);

        $game = new Game([$player1, $player2], $board, $moveGenerator);
        $initialSettingService = new ClassicInitialSetting();
        $initialSettingService->arrangePieces($game);

        $player1castle = $board->getTileByCoordinates('1.6')->getCastle();
        $this->assertSame($player1, $player1castle->getOwner());
        $player2castle = $board->getTileByCoordinates('6.1')->getCastle();
        $this->assertSame($player2, $player2castle->getOwner());
    }

    public function testArrangePiecesFor4Players()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $player3 = $this->createMock(PlayerInterface::class);
        $player4 = $this->createMock(PlayerInterface::class);
        $rows = $columns = [];
        $tiles = $this->createGrid(8, 8, Tile::class, $rows, $columns);
        $board = new Board(Board::TYPE_HEX, $tiles, $rows, $columns);
        $moveGenerator = $this->createMock(MoveGeneratorInterface::class);

        $game = new Game([$player1, $player2, $player3, $player4], $board, $moveGenerator);
        $initialSettingService = new ClassicInitialSetting();
        $initialSettingService->arrangePieces($game);

        $player1castle = $board->getTileByCoordinates('1.8')->getCastle();
        $this->assertSame($player1, $player1castle->getOwner());
        $player2castle = $board->getTileByCoordinates('8.1')->getCastle();
        $this->assertSame($player2, $player2castle->getOwner());
    }

    public function testUnsupportedNumberOfPlayersException()
    {
        $initialSettingService = new ClassicInitialSetting();
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