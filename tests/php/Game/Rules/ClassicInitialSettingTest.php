<?php

namespace FreeElephants\HexoNardsTests\Game\Rules;

use FreeElephants\HexoNards\Board\Board;
use FreeElephants\HexoNards\Board\Hex\Tile;
use FreeElephants\HexoNards\Game\Game;
use FreeElephants\HexoNards\Game\Move\MoveGeneratorInterface;
use FreeElephants\HexoNards\Game\PlayerInterface;
use FreeElephants\HexoNards\Game\Rules\ClassicInitialSetting;
use FreeElephants\HexoNardsTests\AbstractTestCase;
use FreeElephants\HexoNardsTests\Game\Exception\UnsupportedConfigurationException;

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