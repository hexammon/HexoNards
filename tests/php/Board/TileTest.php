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
        $row = new Row(1);
        $column = new Column(1);

        $tile = new Tile($row, $column);

        $this->assertSame($row, $tile->getRow());
        $this->assertSame($column, $tile->getColumn());
        $this->assertCount(1, $row->getTiles());
        $this->assertCount(1, $column->getTiles());
        $this->assertSame('1.1', $tile->getCoordinates());
    }
}