<?php

namespace FreeElephants\HexoNardsTests\Board;

use FreeElephants\HexoNards\Board\Column;
use FreeElephants\HexoNards\Board\Row;
use FreeElephants\HexoNards\Board\Tile;
use FreeElephants\HexoNards\Game\Castle;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TileTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructingAndGetters()
    {
        $row = new Row(1);
        $column = new Column(2);

        $tile = new Tile($row, $column);

        $this->assertSame($row, $tile->getRow());
        $this->assertSame($column, $tile->getColumn());
        $this->assertCount(1, $row->getTiles());
        $this->assertCount(1, $column->getTiles());
        $this->assertSame('1.2', $tile->getCoordinates());
    }

    public function testSetCastle()
    {
        $tile = new Tile($this->createMock(Row::class), $this->createMock(Column::class));
        $castle = $this->createMock(Castle::class);

        $this->assertFalse($tile->hasCastle());
        $tile->setCastle($castle);

        $this->assertTrue($tile->hasCastle());
        $this->assertSame($castle, $tile->getCastle());
    }
}