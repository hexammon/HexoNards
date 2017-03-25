<?php

namespace FreeElephants\HexoNardsTests\Board;

use FreeElephants\HexoNards\Board\Board;
use FreeElephants\HexoNards\Board\Exception\TileOutOfBoundsException;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BoardTest extends AbstractTestCase
{

    public function testGetTileByCoordinates()
    {
        $tile = $this->createTileWithMocks();

        $board = new Board(Board::TYPE_HEX, ['1.1' => $tile], [], []);
        $actual = $board->getTileByCoordinates('1.1');

        $this->assertSame($actual, $tile);
    }

    public function testGetTileByCoordinatesOutOfBoundsException()
    {
        $board = new Board(Board::TYPE_HEX, [], [], []);

        $this->expectException(TileOutOfBoundsException::class);

        $board->getTileByCoordinates('1.1');
    }
}