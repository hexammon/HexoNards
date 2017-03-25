<?php

namespace FreeElephants\HexoNardsTests\Game\Rules;

use FreeElephants\HexoNards\Board\Board;
use FreeElephants\HexoNards\Board\Hex\Tile;
use FreeElephants\HexoNards\Game\Game;
use FreeElephants\HexoNards\Game\Move\MoveGeneratorInterface;
use FreeElephants\HexoNards\Game\PlayerInterface;
use FreeElephants\HexoNards\Game\Rules\ClassicInitialSetting;
use FreeElephants\HexoNardsTests\AbstractTestCase;

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
        $tiles = $this->createGrid(8, 8, Tile::class, $rows, $columns);
        $board = new Board(Board::TYPE_HEX, $tiles, $rows, $columns);
        $moveGenerator = $this->createMock(MoveGeneratorInterface::class);

        $game = new Game([$player1, $player2], $board, $moveGenerator);
        $initialSettingService = new ClassicInitialSetting();
        $initialSettingService->arrangePieces($game);

        $player1castle = $board->getTileByCoordinates('1.8')->getCastle();
        $this->assertSame($player1, $player1castle->getOwner());
        $player2castle = $board->getTileByCoordinates('8.1')->getCastle();
        $this->assertSame($player2, $player2castle->getOwner());
    }
}