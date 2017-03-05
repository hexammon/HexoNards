<?php

namespace FreeElephants\HexoNardsTests\Board;

use FreeElephants\HexoNards\Board\Column;
use FreeElephants\HexoNards\Board\Row;
use FreeElephants\HexoNards\Board\Tile;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TileTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructingAndGetters()
    {
        $row = $this->createMock(Row::class);
        $column = $this->createMock(Column::class);
        $tile = new Tile($row, $column);
        $this->assertSame($row, $tile->getRow());
        $this->assertSame($column, $tile->getColumn());
    }
}