<?php

namespace Hexammon\HexoNardsTests\Board;

use Hexammon\HexoNards\Board\Row;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RowTest extends AbstractTestCase
{

    public function testHasGetNext()
    {
        $row = new Row(1);

        $this->assertFalse($row->hasNext());

        $nextRow = new Row(2);

        $row->setNext($nextRow);
        $this->assertTrue($row->hasNext());
        $this->assertSame($nextRow, $row->getNext());
    }

    public function testHasGetPrevious()
    {
        $row = new Row(1);

        $this->assertFalse($row->hasPrevious());

        $nextRow = new Row(2);
        $row->setNext($nextRow);

        $this->assertTrue($nextRow->hasPrevious());
        $this->assertSame($row, $nextRow->getPrevious());
    }
}